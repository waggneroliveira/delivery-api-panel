@extends('admin.core.admin')

@section('content')

<div class="container-fluid">

    {{-- ============================================================
        HEADER
    ============================================================ --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 mb-1">Detalhes do cliente</h1>

            <p class="text-muted mb-0">
                Visualização dos dados do cliente
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.dashboard.tenants.index') }}"
               class="btn btn-secondary">
                Voltar
            </a>

            <a href="{{ route('admin.dashboard.tenants.edit', $tenant) }}"
               class="btn btn-primary">
                Editar
            </a>

        </div>

    </div>


    {{-- ============================================================
        ALERTAS
    ============================================================ --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Fechar"></button>

        </div>
    @endif


    {{-- ============================================================
        DADOS DO CLIENTE
    ============================================================ --}}
    <div class="card">

        <div class="card-header">
            <h5 class="card-title mb-0">
                Informações do cliente
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                {{-- Nome --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold">
                        Nome
                    </label>

                    <div class="form-control bg-light">
                        {{ $tenant->name ?? '-' }}
                    </div>

                </div>


                {{-- Domínio --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold">
                        Domínio
                    </label>

                    <div class="form-control bg-light">
                        {{ $tenant->domain ?? '-' }}
                    </div>

                </div>


                {{-- E-mail --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold">
                        E-mail
                    </label>

                    <div class="form-control bg-light">
                        {{ $tenant->email ?? '-' }}
                    </div>

                </div>


                {{-- ID --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold">
                        ID do cliente
                    </label>

                    <div class="form-control bg-light">
                        {{ $tenant->id }}
                    </div>

                </div>


                {{-- Criado em --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold">
                        Criado em
                    </label>

                    <div class="form-control bg-light">

                        @if ($tenant->created_at)
                            {{ $tenant->created_at->format('d/m/Y H:i') }}
                        @else
                            -
                        @endif

                    </div>

                </div>


                {{-- Atualizado em --}}
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-bold">
                        Atualizado em
                    </label>

                    <div class="form-control bg-light">

                        @if ($tenant->updated_at)
                            {{ $tenant->updated_at->format('d/m/Y H:i') }}
                        @else
                            -
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
        AÇÕES
    ============================================================ --}}
    <div class="card mt-4">

        <div class="card-header">
            <h5 class="card-title mb-0">
                Ações
            </h5>
        </div>

        <div class="card-body">

            <div class="d-flex gap-2">

                <a href="{{ route('admin.dashboard.tenants.edit', $tenant) }}"
                   class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Editar cliente
                </a>


                <form action="{{ route('admin.dashboard.tenants.destroy', $tenant) }}"
                      method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>
                        Excluir cliente
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

