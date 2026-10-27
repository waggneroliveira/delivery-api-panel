<?php

namespace App\Http\Controllers;

use App\Models\DownloadFicha;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class DownloadFichaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ThemeManager $themeManager)
    {
        $leadDonwloads = DownloadFicha::orderBy('created_at', 'desc')->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.leadFile.index', compact('leadDonwloads','theme', 'themeData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cnpj' => 'required',
            'phone' => 'required'
        ]);

        DownloadFicha::create([
            'name' => $request->name,
            'cnpj' => $request->cnpj,
            'phone' => $request->phone
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DownloadFicha $downloadFicha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DownloadFicha $downloadFicha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DownloadFicha $downloadFicha)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DownloadFicha $downloadFicha)
    {
        $downloadFicha->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $downloadFichaId) {
            $downloadFicha = DownloadFicha::find($downloadFichaId);
    
            if ($downloadFicha) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($downloadFicha)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $downloadFichaId,
                            'name' => $downloadFicha->name,
                            'cnpj' => $downloadFicha->cnpj,
                            'phone' => $downloadFicha->phone,
                            'term_privacy' => $downloadFicha->term_privacy,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $downloadFichaId não encontrado.");
            }
        }
    
        $deleted = downloadFicha::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }
}
