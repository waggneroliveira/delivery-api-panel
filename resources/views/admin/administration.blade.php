@extends('admin.core.admin')

@section('content')
    {{-- ============================================================
        AREA ADMINISTRATIVA
    ============================================================ --}}
    <div class="col-12 m-0 mt-5">
        <!--start lmetricas-->
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card" id="tooltip-container">
                    <div class="card-body">
                        <i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Total de clientes ativos na plataforma"></i>
                        <h4 class="mt-0 font-16">Clientes ativos</h4>
                        <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">42</span></h2>
                        <p class="text-muted mb-0">Total de clientes: 47 <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>8,5%</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card" id="tooltip-container1">
                    <div class="card-body">
                        <i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Receita mensal recorrente dos clientes ativos"></i>
                        <h4 class="mt-0 font-16">Receita mensal</h4>
                        <h2 class="text-primary my-3 text-center">R$ <span data-plugin="counterup">3.247</span></h2>
                        <p class="text-muted mb-0">Receita recorrente mensal <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>12,4%</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card" id="tooltip-container2">
                    <div class="card-body">
                        <i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Quantidade de templates disponíveis na plataforma"></i>
                        <h4 class="mt-0 font-16">Templates</h4>
                        <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">8</span></h2>
                        <p class="text-muted mb-0">Templates disponíveis <span class="float-end"><i class="fa fa-caret-up text-success me-1"></i>2 novos</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card" id="tooltip-container3">
                    <div class="card-body">
                        <i class="fa fa-info-circle text-muted float-end" data-bs-container="#tooltip-container3" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Clientes com pagamentos pendentes ou em atraso"></i>
                        <h4 class="mt-0 font-16">Pagamentos pendentes</h4>
                        <h2 class="text-primary my-3 text-center"><span data-plugin="counterup">5</span></h2>
                        <p class="text-muted mb-0">Clientes com pendências <span class="float-end"><i class="fa fa-caret-down text-success me-1"></i>2 este mês</span></p>
                    </div>
                </div>
            </div>
        </div>
        <!--end lmetricas-->

        <!--start lista de clientes-->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <button type="button" class="d-none btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Add Customers</button>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h4 class="modal-title" id="myCenterModalLabel">Add New Customers</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form>
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Full Name</label>
                                                    <input type="text" class="form-control" id="name" placeholder="Enter full name">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="position" class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="position" placeholder="Enter phone number">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="category" class="form-label">Location</label>
                                                    <input type="text" class="form-control" id="category" placeholder="Enter Location">
                                                </div>
                            
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">Continue</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <div class="col-sm-8">
                                <div class="text-sm-end mt-2 mt-sm-0">
                                    <button type="button" class="btn btn-success mb-2 me-1 d-none"><i class="mdi mdi-cog"></i></button>
                                    <button type="button" class="btn btn-light mb-2 me-1 d-none">Import</button>
                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th>Cliente(s)</th>
                                        <th>Domínio</th>
                                        <th>Template</th>
                                        <th>Plano contratado</th>
                                        <th>Pagamento</th>
                                        <th>Vencimento</th>
                                        <th>Status do pagamento</th>
                                        <th>Criado em</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)                                        
                                        <tr>
                                            <td class="table-user">
                                                @if ($client->path_image_logo_header <> null)                                                    
                                                    <img src="{{ asset('storage/' . $client->path_image_logo_header)}}" alt="table-user" class="me-2 rounded-circle">
                                                @endif
                                                <a href="javascript:void(0);" class="text-body fw-semibold">{{ $client->name }}</a>
                                            </td>
                                            <td>
                                                {{ $client->domain }}
                                            </td>
                                            <td>
                                                {{ $client->templateTheme->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ $client->plan->name }}
                                            </td>
                                            <td>                                               
                                                {{ $client->plan?->price !== null ? 'R$ ' . number_format($client->plan->price, 2, ',', '.') : 'Não informado' }}
                                            </td>
                                            <td>
                                                10/09/2026
                                            </td>
                                            <td class="text-center">
                                                @switch('payment_status')
                                                    @case('paid')
                                                        <span class="badge bg-soft-success text-success">Pago</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-soft-warning text-warning">Pendente</span>
                                                        @break
                                                    @case('overdue')
                                                        <span class="badge bg-soft-danger text-danger">Atrasado</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-soft-warning text-warning">Pendente</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                {{ $client->created_at?->format('d/m/Y') ?? 'Não informado' }}
                                            </td>
                                            <td>
                                                @switch($client->active)
                                                    @case(1)                                                        
                                                            <span class="badge bg-soft-success text-success">Ativo</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge bg-soft-danger text-danger">Inativo</span>                                                        
                                                        @break
                                                    @default
                                                        
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                        {{ $clients->onEachSide(1)->links('pagination::bootstrap-5') }}

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end lista de clientes -->
    </div>

    {{-- ============================================================
        FOOTER
    ============================================================ --}}
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6">
                    <div>
                        <a
                            href="https://www.whi.dev.br/"
                            target="_blank"
                            rel="noopener noreferrer"
                            style="color:#94a0ad;"
                        >
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            © WHI - Web de Alta Inspiração
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-none d-md-flex gap-4 align-items-center justify-content-md-end footer-links">

                        <a
                            href="https://www.whi.dev.br/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-muted"
                        >
                            Sobre a WHI
                        </a>

                        <a
                            href="https://wa.me/5571992768360"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-muted"
                        >
                            Fale conosco
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </footer>

    @include('admin.loadPage.loading')

@endsection
