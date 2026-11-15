
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
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard.product.index') }}">Produtos</a>
                                </li>
                                <li class="breadcrumb-item active">Novo produto</li>
                            </ol>
                        </div>

                        <h4 class="page-title">Cadastrar produto</h4>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Verifique os campos informados:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('admin.dashboard.product.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="productForm"
            >
                @csrf

                @include('admin.modules.product.form')

                <div class="d-flex justify-content-end gap-2 mt-4 mb-4">
                    <a
                        href="{{ route('admin.dashboard.product.index') }}"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary text-black">
                        <i class="mdi mdi-content-save-outline me-1"></i>
                        Cadastrar produto
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
