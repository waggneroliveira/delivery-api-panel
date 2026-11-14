<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'contact' → é o módulo definido no template_modules.php.
        // 'contato.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('contact', 'contato.visualizar', $settingTheme);

        if ($check !== true) {
            return $check; // retorna view 403
        }
        $contact = Contact::query()
            ->orderBy('day_of_week')
            ->orderBy('id')
            ->first();
        $openingHours = Contact::query()
            ->orderBy('day_of_week')
            ->orderBy('id')
            ->get(['day_of_week', 'open_time', 'close_time', 'is_closed']);
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.contact.index', compact('contact', 'openingHours', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $data = $this->contactData($request);
        $openingHours = $this->validatedOpeningHours($request)
            ?? $this->closedOpeningHours();

        try {
            DB::beginTransaction();
                foreach ($openingHours as $openingHour) {
                    Contact::create(array_merge($data, $openingHour));
                }
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollback();
            report($e);
            Alert::error('Erro', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $this->contactData($request);
        $openingHours = $this->validatedOpeningHours($request);
        
        try {
            DB::beginTransaction();
                if ($openingHours === null) {
                    Contact::query()
                        ->where('tenant_id', $contact->tenant_id)
                        ->get()
                        ->each(fn (Contact $record) => $record->fill($data)->save());
                } else {
                    $this->syncOpeningHours($contact, $data, $openingHours);
                }
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            Alert::error('Erro', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    private function contactData(Request $request): array
    {
        $data = $request->except('opening_hours');
        $maps = $request->input('maps');

        if (Str::contains($maps ?? '', '<iframe')) {
            preg_match('/src="([^"]+)"/', $maps, $matches);
            $maps = $matches[1] ?? null;
        }

        $data['maps'] = $maps;

        return $data;
    }

    private function validatedOpeningHours(Request $request): ?array
    {
        if (!$request->exists('opening_hours')) {
            return null;
        }

        $validator = Validator::make($request->all(), [
            'opening_hours' => ['required', 'array', 'size:7'],
            'opening_hours.*' => ['required', 'array'],
            'opening_hours.*.day_of_week' => ['required', 'integer', 'between:1,7', 'distinct'],
            'opening_hours.*.open_time' => ['nullable', 'date_format:H:i'],
            'opening_hours.*.close_time' => ['nullable', 'date_format:H:i'],
            'opening_hours.*.is_closed' => ['required', 'boolean'],
        ]);

        $validator->after(function ($validator) use ($request) {
            foreach ($request->input('opening_hours', []) as $index => $openingHour) {
                if (
                    !is_array($openingHour) ||
                    filter_var($openingHour['is_closed'] ?? false, FILTER_VALIDATE_BOOLEAN)
                ) {
                    continue;
                }

                if (empty($openingHour['open_time'])) {
                    $validator->errors()->add(
                        "opening_hours.{$index}.open_time",
                        'Informe o horário de abertura ou marque o dia como fechado.'
                    );
                }

                if (empty($openingHour['close_time'])) {
                    $validator->errors()->add(
                        "opening_hours.{$index}.close_time",
                        'Informe o horário de fechamento ou marque o dia como fechado.'
                    );
                }
            }
        });

        $validated = $validator->validate();

        return collect($validated['opening_hours'])
            ->map(function (array $openingHour) {
                $isClosed = filter_var($openingHour['is_closed'], FILTER_VALIDATE_BOOLEAN);

                return [
                    'day_of_week' => (int) $openingHour['day_of_week'],
                    'open_time' => $isClosed ? null : $openingHour['open_time'],
                    'close_time' => $isClosed ? null : $openingHour['close_time'],
                    'is_closed' => $isClosed,
                ];
            })
            ->sortBy('day_of_week')
            ->values()
            ->all();
    }

    private function closedOpeningHours(): array
    {
        return collect(range(1, 7))
            ->map(fn (int $dayOfWeek) => [
                'day_of_week' => $dayOfWeek,
                'open_time' => null,
                'close_time' => null,
                'is_closed' => true,
            ])
            ->all();
    }

    private function syncOpeningHours(Contact $contact, array $data, array $openingHours): void
    {
        $existingByDay = Contact::query()
            ->where('tenant_id', $contact->tenant_id)
            ->orderBy('id')
            ->get()
            ->toBase()
            ->groupBy('day_of_week');

        $days = [];

        foreach ($openingHours as $openingHour) {
            $dayOfWeek = $openingHour['day_of_week'];
            $dayRecords = $existingByDay->get($dayOfWeek, collect());
            $record = $dayRecords->shift();

            if ($record) {
                $record->fill(array_merge($data, $openingHour))->save();
            } else {
                Contact::create(array_merge($data, $openingHour));
            }

            $dayRecords->each->delete();
            $days[] = $dayOfWeek;
        }

        $existingByDay
            ->except($days)
            ->flatten()
            ->each
            ->delete();
    }


    public function destroy(Contact $contact)
    {
        Contact::query()
            ->where('tenant_id', $contact->tenant_id)
            ->get()
            ->each
            ->delete();
        session()->flash('success', __('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
