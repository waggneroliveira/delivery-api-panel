<?php

namespace App\Http\Controllers;

use App\Models\ImpactSectionMetric;
use Illuminate\Http\Request;

class ImpactSectionMetricController extends Controller
{
    public function index()
    {
        $metrics = ImpactSectionMetric::orderBy('id')->get();

        return response()->json($metrics);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'impact_section_id' => ['required', 'integer', 'exists:impact_sections,id'],
            'title' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'active' => ['nullable', 'boolean'],
        ]);

        $validated['active'] = $request->boolean('active');

        $metric = ImpactSectionMetric::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Métrica adicionada com sucesso.');
    }

    public function update(Request $request, ImpactSectionMetric $impactSectionMetric)
    {
        $validated = $request->validate([
            'impact_section_id' => ['required', 'integer', 'exists:impact_sections,id'],
            'title' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'active' => ['nullable', 'boolean'],
        ]);

        $validated['active'] = $request->boolean('active');

        $impactSectionMetric->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Métrica atualizada com sucesso.');
    }

    public function destroy(ImpactSectionMetric $impactSectionMetric)
    {
        $impactSectionMetric->delete();

        return redirect()
            ->back()
            ->with('success', 'Métrica removida com sucesso.');
    }
}