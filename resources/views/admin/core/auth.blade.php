<!DOCTYPE html>
<html  lang="en" data-layout-mode="detached" data-topbar-color="dark" data-sidenav-user="true">
    <head>
        <meta charset="utf-8" />
        <title>{{env('APP_NAME')}} - Painel Gerenciador</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Sistema de gerenciamento do site {{env('APP_NAME')}}" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/admin/images/whi-green-horizontal.png')}}">

        <link href="{{ asset('build/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('build/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('build/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('build/admin/css/custom.css') }}" rel="stylesheet" type="text/css" />

        <script src="{{ asset('build/admin/js/head.js') }}"></script>
   
    </head>

    <body class="authentication-bg authentication-bg-pattern">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        @yield('content')
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

        <!-- Authentication js -->
        {{-- <script src="{{ asset('build/admin/js/pages/authentication.init.js') }}"></script> --}}

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        @if (session('success'))
            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
                <div id="successToast" class="toast border-0 shadow-sm" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body bg-success d-flex align-items-center gap-3 py-2 px-2 rounded-3">

                        <div
                            class="d-flex align-items-center justify-content-center flex-shrink-0"
                            style="
                                width: 36px;
                                height: 36px;
                                border-radius: 50%;
                                background: #FFF;
                                color: #1abc9c;"
                        >
                            <i class="ri-check-line fs-5"></i>
                        </div>

                        <div class="flex-grow-1">
                            <div class="fw-semibold mb-1 text-white">
                                {{ $responseSuccessName ?? 'Sucesso!' }}
                            </div>

                            <div class="small text-white">
                                {{ session('success') }}
                            </div>
                        </div>

                        <button
                            type="button"
                            class="btn-close btn-close-white align-self-start"
                            data-bs-dismiss="toast"
                            aria-label="Fechar"
                        ></button>

                    </div>
                </div>
            </div>

            <style>
                #successToast {
                    opacity: 0;
                    transform: translateX(110%);
                }

                #successToast.toast-enter {
                    animation: toastEnter 0.4s ease forwards;
                }

                #successToast.toast-leave {
                    animation: toastLeave 0.4s ease forwards;
                }

                @keyframes toastEnter {
                    from {
                        opacity: 0;
                        transform: translateX(110%);
                    }

                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }

                @keyframes toastLeave {
                    from {
                        opacity: 1;
                        transform: translateX(0);
                    }

                    to {
                        opacity: 1;
                        transform: translateX(110%);
                    }
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    const toastElement = document.getElementById('successToast');

                    if (!toastElement || typeof bootstrap === 'undefined') {
                        return;
                    }

                    const toast = new bootstrap.Toast(toastElement, {
                        animation: false,
                        autohide: false
                    });

                    // Entrada
                    toastElement.classList.add('toast-enter');

                    setTimeout(function () {
                        toast.show();
                    }, 150);


                    // Saída manual
                    setTimeout(function () {

                        toastElement.classList.remove('toast-enter');
                        toastElement.classList.add('toast-leave');

                        // Aguarda a animação terminar
                        setTimeout(function () {
                            toast.hide();
                        }, 400);

                    }, 3650);

                });
            </script>
        @endif
    </body>
</html>
