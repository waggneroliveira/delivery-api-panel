<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanModuleLimit;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlansController extends Controller
{
    /**
     * Lista os planos.
     */
    public function index(ThemeManager $themeManager)
    {
        $plans = Plan::with(['moduleLimits', 'tenants'])
        ->withCount('tenants')
        ->orderBy('id', 'desc')
        ->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.plans.index', compact('plans', 'theme', 'themeData'));
    }


    /**
     * Formulário de criação.
     */
    public function create(ThemeManager $themeManager)
    {
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $availableModules = $themeManager->availableModules();

        return view('admin.blades.plans.create', compact('theme', 'themeData', 'availableModules'));
    }


    /**
     * Salva um novo plano.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'price' => [
                'nullable',
                'string',
                'min:0',
            ],
            'monthly_price' => [
                'nullable',
                'string',
                'min:0',
            ],
            'description' => [
                'nullable',
                'string',
                'min:0',
            ],
            'text' => [
                'nullable',
                'string',
                'min:0',
            ],

            'active' => [
                'nullable',
                'boolean',
            ],
            'popular' => [
                'nullable',
                'boolean',
            ],

            'limits' => [
                'nullable',
                'array',
            ],

            'limits.*' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);


        DB::transaction(function () use ($validated, $request) {

            $plan = Plan::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'price' => $validated['price'] ?? 0,
                'monthly_price' => $validated['monthly_price'] ?? 0,
                'description' => $validated['description'],
                'text' => $validated['text'],
                'active' => $request->boolean('active', true),
                'popular' => $request->boolean('popular', true),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Limites dos módulos
            |--------------------------------------------------------------------------
            */

            $this->syncModuleLimits(
                $plan,
                $validated['limits'] ?? []
            );
        });


        return redirect()
            ->route('admin.dashboard.plans.index')
            ->with(
                'success',
                'Plano criado com sucesso.'
            );
    }


    /**
     * Exibe um plano.
     */
    public function show(Plan $plan, ThemeManager $themeManager)
    {
        $plan->load('moduleLimits');
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $availableModules = $themeManager->availableModules();
        return view('admin.blades.plans.show', compact('plan', 'availableModules', 'theme', 'themeData'));
    }


    /**
     * Formulário de edição.
     */
    public function edit(Plan $plan, ThemeManager $themeManager)
    {
        $plan->load('moduleLimits');
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $availableModules = $themeManager->availableModules();
        return view('admin.blades.plans.edit', compact('plan', 'availableModules', 'theme', 'themeData'));
    }


    /**
     * Atualiza um plano.
     */
    public function update(Request $request, Plan $plan) {
        
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'price' => [
                'nullable',
                'string',
                'min:0',
            ],
            'monthly_price' => [
                'nullable',
                'string',
                'min:0',
            ],
            'description' => [
                'nullable',
                'string',
                'min:0',
            ],
            'text' => [
                'nullable',
                'string',
                'min:0',
            ],

            'active' => [
                'nullable',
                'boolean',
            ],
            'popular' => [
                'nullable',
                'boolean',
            ],

            'limits' => [
                'nullable',
                'array',
            ],

            'limits.*' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);


        DB::transaction(function () use (
            $validated,
            $request,
            $plan
        ) {

            $plan->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'price' => $validated['price'] ?? 0,
                'monthly_price' => $validated['monthly_price'] ?? 0,
                'description' => $validated['description'],
                'text' => $validated['text'],
                'active' => $request->boolean('active', true),
                'popular' => $request->boolean('popular', false),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Atualiza limites
            |--------------------------------------------------------------------------
            */

            $this->syncModuleLimits(
                $plan,
                $validated['limits'] ?? []
            );
        });


        return redirect()
            ->route('admin.dashboard.plans.index')
            ->with(
                'success',
                'Plano atualizado com sucesso.'
            );
    }


    /**
     * Ativa / desativa um plano.
     */
    public function toggleActive(Plan $plan)
    {
        $plan->update([
            'active' => !$plan->active,
        ]);

        return back()->with(
            'success',
            $plan->active
                ? 'Plano ativado com sucesso.'
                : 'Plano desativado com sucesso.'
        );
    }


    /**
     * Exclui um plano.
     */
    public function destroy(Plan $plan)
    {
        /*
        |--------------------------------------------------------------------------
        | Evita excluir plano que possui tenants
        |--------------------------------------------------------------------------
        */

        if ($plan->tenants()->exists()) {
            return back()->with(
                'error',
                'Não é possível excluir este plano porque existem clientes vinculados a ele.'
            );
        }


        DB::transaction(function () use ($plan) {

            $plan->moduleLimits()->delete();

            $plan->delete();
        });


        return redirect()
            ->route('admin.dashboard.plans.index')
            ->with(
                'success',
                'Plano excluído com sucesso.'
            );
    }


    /**
     * Sincroniza os limites dos módulos.
     */
    protected function syncModuleLimits(
        Plan $plan,
        array $limits
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Remove limites antigos
        |--------------------------------------------------------------------------
        */

        $plan->moduleLimits()->delete();


        /*
        |--------------------------------------------------------------------------
        | Cria os novos limites
        |--------------------------------------------------------------------------
        */

        foreach ($limits as $module => $limit) {

            if ($limit === null || $limit === '') {
                continue;
            }

            PlanModuleLimit::create([
                'plan_id' => $plan->id,
                'module' => $module,
                'limit' => (int) $limit,
            ]);
        }
    }
}