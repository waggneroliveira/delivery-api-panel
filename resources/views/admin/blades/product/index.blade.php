
@extends('admin.core.admin')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Produtos</li>
                            </ol>
                        </div>

                        <h4 class="page-title">Produtos</h4>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    {{-- Filtros --}}
                    <form
                        action="{{ route('admin.dashboard.product.index') }}"
                        method="GET"
                        class="mb-4"
                    >
                        <div class="row g-3 align-items-end">

                            <div class="col-md-4">
                                <label class="form-label">Pesquisar produto</label>

                                <input
                                    type="text"
                                    name="title"
                                    class="form-control"
                                    value="{{ request('title') }}"
                                    placeholder="Nome do produto"
                                >
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Categoria</label>

                                <select name="product_category_id" class="form-select">
                                    <option value="">Todas</option>

                                    @foreach ($categories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            {{ request('product_category_id') == $category->id ? 'selected' : '' }}
                                        >
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Tipo</label>

                                <select name="product_type" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="food" {{ request('product_type') === 'food' ? 'selected' : '' }}>
                                        Produto
                                    </option>
                                    <option value="combo" {{ request('product_type') === 'combo' ? 'selected' : '' }}>
                                        Combo
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary text-black w-100">
                                    <i class="mdi mdi-magnify"></i>
                                    Filtrar
                                </button>

                                <a
                                    href="{{ route('admin.dashboard.product.index') }}"
                                    class="btn btn-light w-100"
                                >
                                    Limpar
                                </a>
                            </div>

                        </div>
                    </form>

                    {{-- Ações --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>
                            @if (
                                Auth::user()->hasRole('Super') ||
                                Auth::user()->can('usuario.tornar usuario master') ||
                                (
                                    Auth::user()->can('produtos.visualizar') &&
                                    Auth::user()->can('produtos.remover')
                                )
                            )
                                <button
                                    id="btSubmitDelete"
                                    data-route="{{ route('admin.dashboard.product.destroySelected') }}"
                                    type="button"
                                    class="btSubmitDelete btn btn-danger"
                                    style="display:none"
                                >
                                    Excluir selecionados
                                </button>
                            @endif
                        </div>

                        @if (
                            Auth::user()->hasRole('Super') ||
                            Auth::user()->can('usuario.tornar usuario master') ||
                            (
                                Auth::user()->can('produtos.visualizar') &&
                                Auth::user()->can('produtos.criar')
                            )
                        )
                            <a
                                href="{{ route('admin.dashboard.product.create') }}"
                                class="btn btn-primary text-black"
                            >
                                <i class="mdi mdi-plus-circle me-1"></i>
                                Novo produto
                            </a>
                        @endif

                    </div>

                    {{-- Tabela --}}
                    <div class="table-responsive">

                        <table class="table table-centered table-striped table-sortable">

                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="bs-checkbox">
                                        <input type="checkbox" name="btnSelectAll">
                                    </th>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Tipo</th>
                                    <th>Preço</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>

                            <tbody data-route="{{ route('admin.dashboard.product.sorting') }}">

                                @forelse ($products as $key => $product)

                                    <tr data-code="{{ $product->id }}">

                                        <td>
                                            <span class="btnDrag mdi mdi-drag-horizontal font-22"></span>
                                        </td>

                                        <td class="bs-checkbox">
                                            <input
                                                type="checkbox"
                                                name="btnSelectItem"
                                                class="btnSelectItem"
                                                value="{{ $product->id }}"
                                            >
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center gap-2">

                                                @if ($product->path_image_thumbnail ?? $product->path_image)
                                                    <img
                                                        src="{{ asset('storage/' . ($product->path_image_thumbnail ?? $product->path_image)) }}"
                                                        alt="{{ $product->title }}"
                                                        width="48"
                                                        height="48"
                                                        style="object-fit:cover"
                                                        class="rounded"
                                                    >
                                                @endif

                                                <div>
                                                    <strong>{{ $product->title }}</strong>

                                                    @if ($product->featured)
                                                        <div>
                                                            <span class="badge bg-warning text-dark">
                                                                Destaque
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            {{ $product->category->title ?? 'Sem categoria' }}
                                        </td>

                                        <td>
                                            @if ($product->product_type === 'combo')
                                                <span class="badge bg-info">Combo</span>
                                            @else
                                                <span class="badge bg-secondary">Produto</span>
                                            @endif
                                        </td>

                                        <td>
                                            R$ {{ number_format((float) $product->price, 2, ',', '.') }}
                                        </td>

                                        <td>
                                            @if ($product->active)
                                                <span class="badge bg-success">Ativo</span>
                                            @else
                                                <span class="badge bg-danger">Inativo</span>
                                            @endif
                                        </td>

                                        <td class="text-center">

                                            @if (
                                                Auth::user()->hasRole('Super') ||
                                                Auth::user()->can('usuario.tornar usuario master') ||
                                                (
                                                    Auth::user()->can('produtos.visualizar') &&
                                                    Auth::user()->can('produtos.editar')
                                                )
                                            )
                                                <a
                                                    href="{{ route('admin.dashboard.product.edit', ['product' => $product->id]) }}"
                                                    class="btn btn-sm btn-primary text-black"
                                                    title="Editar"
                                                >
                                                    <i class="mdi mdi-pencil"></i>
                                                </a>
                                            @endif

                                            @if (
                                                Auth::user()->hasRole('Super') ||
                                                Auth::user()->can('usuario.tornar usuario master') ||
                                                (
                                                    Auth::user()->can('produtos.visualizar') &&
                                                    Auth::user()->can('produtos.remover')
                                                )
                                            )
                                                <form
                                                    action="{{ route('admin.dashboard.product.destroy', ['product' => $product->id]) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-danger demo-delete-row btSubmitDeleteItem"
                                                        title="Excluir"
                                                    >
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="mdi mdi-package-variant-closed font-36 text-muted"></i>

                                            <h5 class="mt-2">Nenhum produto encontrado</h5>

                                            <p class="text-muted mb-0">
                                                Cadastre seu primeiro produto para começar.
                                            </p>
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>
                        </table>

                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        {{ $products->withQueryString()->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
