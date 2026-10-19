<?php

namespace App\Http\Controllers;

use App\Models\FormIndex;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FormIndexController extends Controller
{

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') &&
          !Auth::user()->hasPermissionTo('lead contato.visualizar')){
            return view('admin.error.403', compact('settingTheme'));
        }
        $formIndexs = FormIndex::get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.lead.index', compact('formIndexs', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|nullable|string|max:255',
            'email' => 'sometimes|nullable|email|max:255',
            'phone' => 'sometimes|nullable|string|max:255',
            'subject' => 'sometimes|nullable|string|max:255',
            'text' => 'sometimes|nullable|string|max:255',
            'term_privacy' => 'sometimes|nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            FormIndex::create([
                'name' => $validated['name'] ?? null,
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'subject' => $validated['subject'] ?? null,
                'text' => $validated['text'] ?? null,
                'term_privacy' => $validated['term_privacy'] ?? 0,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mensagem enviada com sucesso!',
            ]);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => 'Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(FormIndex $formIndex)
    {
        //
    }
}
