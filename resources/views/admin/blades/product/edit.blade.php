@extends('admin.core.admin')
@section('content')
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active"><a href="{{route('admin.dashboard.product.index')}}">Produtos</a></li>
                                <li class="breadcrumb-item active">Editar Produto</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Editar Produto</h4>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">

                <div class="col-2 mb-2">
                    @if (Auth::user()->hasPermissionTo('galeria de produtos.visualizar') &&
                    Auth::user()->hasPermissionTo('galeria de produtos.criar') ||
                    Auth::user()->hasPermissionTo('usuario.tornar usuario master') || 
                    Auth::user()->hasRole('Super'))
                    <button class="table-edit-button btn btn-primary text-black" data-bs-toggle="modal" data-bs-target="#modal-gellery-edit-{{$product->id}}">
                       {!! !$product->galleries->count() > 0 
                        ? '<i class="mdi mdi-plus-circle me-1"></i> Criar Galeria' 
                        : '<i class="mdi mdi-pencil me-1"></i> Editar Galeria' !!}
                    </button>
                    @endif
                </div>

                <div class="modal fade" id="modal-gellery-edit-{{$product->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h4 class="modal-title" id="myCenterModalLabel">
                                    <i class="mdi mdi-image-multiple me-2"></i>Galeria de Imagens
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            
                            <div class="modal-body p-4">
                                <form action="{{route('admin.dashboard.gallery.productGallery.store')}}" 
                                    method="post" 
                                    enctype="multipart/form-data"
                                    id="galleryForm-{{$product->id}}">
                                    
                                    @csrf
                                    @method('post')
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    
                                    <!-- Área de Upload Aprimorada -->
                                    <div class="upload-area mb-4" id="uploadArea-{{$product->id}}">
                                        <div class="fileInputPreview">
                                            <!-- Preview de imagens selecionadas -->
                                            <div class="preview-container mb-3" id="previewContainer-{{$product->id}}">
                                                <!-- Imagens preview serão inseridas aqui via JS -->
                                            </div>
                                            
                                            <!-- Área de drop/click -->
                                            <div class="upload-box text-center p-4 border rounded-3" 
                                                id="uploadBox-{{$product->id}}"
                                                onclick="document.getElementById('fileInput-{{$product->id}}').click()"
                                                ondragover="handleDragOver(event)"
                                                ondragleave="handleDragLeave(event)"
                                                ondrop="handleDrop(event, '{{$product->id}}')">
                                                
                                                <div class="upload-icon mb-3">
                                                    <i class="bx bx-cloud-upload" style="font-size: 48px; color: #6c757d;"></i>
                                                </div>
                                                
                                                <h5 class="fileText">Arraste imagens ou clique para fazer upload</h5>
                                                <p class="fileDescription text-muted mb-0">
                                                    <i class="bx bx-info-circle me-1"></i>
                                                    Suporte: JPG, PNG, GIF | Máx: 2MB por imagem
                                                </p>
                                                
                                                <input type="file" 
                                                    id="fileInput-{{$product->id}}" 
                                                    name="file[]" 
                                                    class="fileInput d-none" 
                                                    multiple 
                                                    accept="image/*"
                                                    onchange="handleFileSelect(this, '{{$product->id}}')">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Contador e Lista de Arquivos -->
                                    <div class="files-info mb-3" id="filesInfo-{{$product->id}}" style="display: none;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-primary" id="fileCount-{{$product->id}}">
                                                <i class="bx bx-images me-1"></i>0 arquivos selecionados
                                            </span>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFiles('{{$product->id}}')">
                                                <i class="bx bx-trash me-1"></i>Limpar todos
                                            </button>
                                        </div>
                                        <div class="file-list" id="fileList-{{$product->id}}">
                                            <!-- Lista de arquivos será inserida aqui -->
                                        </div>
                                    </div>
                                    
                                    <!-- Barra de Progresso (opcional) -->
                                    <div class="progress mb-3" id="progressBar-{{$product->id}}" style="display: none; height: 8px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                            role="progressbar" 
                                            style="width: 0%"
                                            aria-valuenow="0" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    
                                    <hr class="my-3">
                                    
                                    <!-- Botões de Ação -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted small" id="uploadHint-{{$product->id}}">
                                                <i class="bx bx-info-circle me-1"></i>
                                                Nenhum arquivo selecionado
                                            </span>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">
                                                <i class="bx bx-x me-1"></i>Cancelar
                                            </button>
                                            <button type="submit" class="btn btn-primary" id="submitBtn-{{$product->id}}" disabled>
                                                <i class="bx bx-upload me-1"></i>Enviar Arquivos
                                            </button>
                                        </div>
                                    </div>
                                    
                                </form>

                                <div class="table-responsive">
                                    <table class="table-sortable table table-centered table-nowrap table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="bs-checkbox">
                                                    <label><input name="btnSelectAll" type="checkbox"></label>
                                                </th>
                                                <th>Imagem</th>
                                                <th style="width: 85px;">Ações</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody data-route="{{route('admin.dashboard.gallery.productGallery.sorting')}}">
                                            @foreach ($product->galleries as $key => $file)
                                                <tr data-code="{{$file->id}}">
                                                    <td><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                    <td class="bs-checkbox">
                                                        <label><input data-index="{{$key}}" name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$file->id}}"></label>
                                                    </td>
                                                    <td class="table-user text-center">
                                                        @if ($file->file)
                                                            <img src="{{ asset('storage/'.$file->file) }}" name="file" alt="table-user" class="me-2 rounded-circle">
                                                        @endif
                                                    </td>
                                                    <td class="d-flex gap-lg-1 justify-center">
                                                        <form action="{{route('admin.dashboard.gallery.productGallery.destroy',['productGallery' => $file->id])}}" style="width: 30px" method="POST">
                                                            @method('DELETE') @csrf        
                                                            
                                                            <button type="button" style="width: 30px"class="demo-delete-row btn btn-danger btn-xs btn-icon btSubmitDeleteItem"><i class="fa fa-times"></i></button>
                                                        </form> 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.dashboard.product.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        
                        @includeIf("admin.templates.{$themeData->slug}.{$themeData->template_variation}.product.form", ['product', 'themeData'])    
  
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{route('admin.dashboard.product.index')}}" class="btn btn-danger waves-effect waves-light">{{__('dashboard.btn_cancel')}}</a>
                        <button type="submit" class="btn btn-primary text-black waves-effect waves-light">{{__('dashboard.btn_save')}}</button>
                    </div>                                                                                                                                                                                            
                </form>
            </div> <!-- fecha a row aberta -->

        </div> <!-- fecha container-fluid -->
    </div> <!-- fecha content -->
</div> <!-- fecha content-page -->

{{-- Upload multiplo --}}
<script>
    // Funções aprimoradas para upload múltiplo
    let selectedFiles = {};

    function handleFileSelect(input, productId) {
        const files = Array.from(input.files);
        processFiles(files, productId);
    }

    function handleDragOver(event) {
        event.preventDefault();
        event.stopPropagation();
        event.currentTarget.classList.add('dragover');
    }

    function handleDragLeave(event) {
        event.preventDefault();
        event.stopPropagation();
        event.currentTarget.classList.remove('dragover');
    }

    function handleDrop(event, productId) {
        event.preventDefault();
        event.stopPropagation();
        
        const uploadBox = event.currentTarget;
        uploadBox.classList.remove('dragover');
        
        const files = Array.from(event.dataTransfer.files);
        const validFiles = files.filter(file => file.type.startsWith('image/'));
        
        if (validFiles.length === 0) {
            showNotification('Apenas imagens são permitidas', 'error');
            return;
        }
        
        processFiles(validFiles, productId);
    }

    function processFiles(files, productId) {
        if (!selectedFiles[productId]) {
            selectedFiles[productId] = [];
        }
        
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        files.forEach(file => {
            // Validar tipo
            if (!file.type.startsWith('image/')) {
                showNotification(`${file.name} não é uma imagem válida`, 'warning');
                return;
            }
            
            // Validar tamanho
            if (file.size > maxSize) {
                showNotification(`${file.name} excede 2MB`, 'error');
                return;
            }
            
            selectedFiles[productId].push(file);
        });
        
        updateUI(productId);
    }

    function updateUI(productId) {
        const files = selectedFiles[productId] || [];
        const fileInput = document.getElementById(`fileInput-${productId}`);
        const filesInfo = document.getElementById(`filesInfo-${productId}`);
        const submitBtn = document.getElementById(`submitBtn-${productId}`);
        const uploadHint = document.getElementById(`uploadHint-${productId}`);
        const fileCount = document.getElementById(`fileCount-${productId}`);
        
        // Atualizar input file (hack para permitir re-upload)
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
        
        // Mostrar/ocultar área de informações
        if (files.length > 0) {
            filesInfo.style.display = 'block';
            submitBtn.disabled = false;
            
            // Atualizar contador
            const count = files.length;
            fileCount.innerHTML = `<i class="bx bx-images me-1"></i>${count} ${count === 1 ? 'arquivo' : 'arquivos'} selecionado${count === 1 ? '' : 's'}`;
            
            // Atualizar hint
            uploadHint.innerHTML = `<i class="bx bx-check-circle me-1"></i>${count} ${count === 1 ? 'arquivo pronto' : 'arquivos prontos'} para upload`;
            uploadHint.className = 'text-success small';
            
            // Gerar previews
            generatePreviews(files, productId);
            
            // Gerar lista de arquivos
            generateFileList(files, productId);
        } else {
            filesInfo.style.display = 'none';
            submitBtn.disabled = true;
            uploadHint.innerHTML = '<i class="bx bx-info-circle me-1"></i>Nenhum arquivo selecionado';
            uploadHint.className = 'text-muted small';
            
            // Limpar previews
            document.getElementById(`previewContainer-${productId}`).innerHTML = '';
            document.getElementById(`fileList-${productId}`).innerHTML = '';
        }
    }

    function generatePreviews(files, productId) {
        const previewContainer = document.getElementById(`previewContainer-${productId}`);
        previewContainer.innerHTML = '';
        
        files.slice(0, 6).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}">
                    <button type="button" class="remove-file" onclick="removeFile(${index}, '${productId}')">
                        <i class="bx bx-x"></i>
                    </button>
                `;
                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
        
        // Indicador de mais arquivos
        if (files.length > 6) {
            const moreItem = document.createElement('div');
            moreItem.className = 'preview-item d-flex align-items-center justify-content-center bg-light';
            moreItem.innerHTML = `<span class="text-muted">+${files.length - 6}</span>`;
            previewContainer.appendChild(moreItem);
        }
    }

    function generateFileList(files, productId) {
        const fileList = document.getElementById(`fileList-${productId}`);
        fileList.innerHTML = '';
        
        files.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            
            // Ícone baseado no tipo
            let icon = 'bx bx-file';
            if (file.type.includes('image')) icon = 'bx bx-image';
            
            // Formatar tamanho
            const size = (file.size / 1024).toFixed(1) + ' KB';
            
            fileItem.innerHTML = `
                <i class="${icon}"></i>
                <span class="file-name" title="${file.name}">${file.name}</span>
                <span class="file-size">${size}</span>
                <span class="remove-single" onclick="removeFile(${index}, '${productId}')">
                    <i class="bx bx-trash"></i>
                </span>
            `;
            
            fileList.appendChild(fileItem);
        });
    }

    function removeFile(index, productId) {
        if (selectedFiles[productId]) {
            selectedFiles[productId].splice(index, 1);
            updateUI(productId);
        }
    }

    function clearFiles(productId) {
        selectedFiles[productId] = [];
        updateUI(productId);
    }

    function showNotification(message, type = 'info') {
        // Criar toast notification
        const toast = document.createElement('div');
        toast.className = `upload-toast alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
        toast.innerHTML = `
            <i class="bx bx-${type === 'error' ? 'error-circle' : type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // Preview de imagem individual
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = input.closest('.fileInputPreview').querySelector('.preview-file-img');
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Reset do formulário quando modal for fechado
    document.addEventListener('DOMContentLoaded', function() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                const productId = this.id.split('-').pop();
                clearFiles(productId);
            });
        });
    });
</script>  
<style>
    /* Estilos aprimorados para upload */
    .upload-box {
        background: linear-gradient(to bottom, #f8f9fa, #ffffff);
        border: 2px dashed #dee2e6 !important;
        transition: all 0.3s ease;
        cursor: pointer;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .upload-box:hover,
    .upload-box.dragover {
        border-color: #0d6efd !important;
        background: linear-gradient(to bottom, #e7f1ff, #f8f9fa);
    }

    .upload-box.dragover {
        background: #e7f1ff;
        border-color: #0d6efd;
    }

    .upload-icon {
        transition: transform 0.3s ease;
    }

    .upload-box:hover .upload-icon {
        transform: translateY(-5px);
    }

    .upload-icon i {
        color: #6c757d;
    }

    .upload-box:hover .upload-icon i {
        color: #0d6efd;
    }

    /* Preview de imagens */
    .preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        max-height: 300px;
        overflow-y: auto;
        padding: 5px;
    }

    .preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        aspect-ratio: 1;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .preview-item:hover img {
        transform: scale(1.1);
    }

    .preview-item .remove-file {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 0;
        font-size: 16px;
    }

    .preview-item:hover .remove-file {
        opacity: 1;
    }

    /* Lista de arquivos */
    .file-list {
        max-height: 150px;
        overflow-y: auto;
        background: #f8f9fa;
        border-radius: 6px;
        padding: 10px;
    }

    .file-item {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        background: white;
        border-radius: 6px;
        margin-bottom: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .file-item i {
        margin-right: 10px;
        color: #6c757d;
    }

    .file-item .file-name {
        flex: 1;
        font-size: 0.9rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-item .file-size {
        font-size: 0.8rem;
        color: #6c757d;
        margin: 0 10px;
    }

    .file-item .remove-single {
        color: #dc3545;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: background 0.2s ease;
    }

    .file-item .remove-single:hover {
        background: #fee;
    }

    /* Loading state */
    .upload-box.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    /* Toast de notificação */
    .upload-toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }
</style>

@endsection