<?php

namespace App\Modules\Client\Presentation\Controllers;

use App\Models\Client;
use App\Modules\Client\Business\ClientService;
use App\Modules\Client\DTO\ClientData;
use App\Modules\Client\Presentation\Requests\StoreClientRequest;
use App\Modules\Client\Presentation\Requests\UpdateClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClientController
{
    public function __construct(protected ClientService $service)
    {
    }

    public function index()
    {
        $clients = $this->service->list();

        return view('admin.blades.client.index', compact('clients'));
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $clientData = ClientData::fromArray($request->validated());
            $this->service->create($clientData, $request->file('path_image'));

            DB::commit();

            session()->flash('success', 'Cadastro realizado com sucesso!');

            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', 'Erro no cadastro: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function update(UpdateClientRequest $request, Client $client): RedirectResponse
    {
        $client = auth('client')->user();
        $clientData = ClientData::fromArray($request->validated());
        $imageFile = $request->hasFile('path_image') ? $request->file('path_image') : null;

        $this->service->update($client, $clientData, $imageFile);

        return back()->with('success', 'Dados atualizados com sucesso!');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->service->delete($client);
        Session::flash('success', __('dashboard.response_item_delete'));

        return redirect()->back();
    }
}
