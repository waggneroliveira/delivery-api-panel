<!-- Área de Upload Aprimorada -->
<div class="upload-area mb-4" id="uploadArea">
    <div class="fileInputPreview">
        <!-- Preview de imagens selecionadas -->
        <div class="preview-container mb-3" id="previewContainer">
            <!-- Imagens preview serão inseridas aqui via JS -->
        </div>
        
        <!-- Área de drop/click -->
        <div class="upload-box text-center p-4 border rounded-3" 
            id="uploadBox"
            onclick="document.getElementById('fileInput').click()"
            ondragover="handleDragOver(event)"
            ondragleave="handleDragLeave(event)"
            ondrop="handleDrop(event, '{{isset($gallery) ?? $gallery->id}}')">
            
            <div class="upload-icon mb-3">
                <i class="bx bx-cloud-upload" style="font-size: 48px; color: #6c757d;"></i>
            </div>
            
            <h5 class="fileText">Arraste imagens ou clique para fazer upload</h5>
            <p class="fileDescription text-muted mb-0">
                <i class="bx bx-info-circle me-1"></i>
                Suporte: JPG, PNG, GIF | Máx: 2MB por imagem
            </p>
            
            <input type="file" 
                id="fileInput" 
                name="file[]" 
                class="fileInput d-none" 
                multiple 
                accept="image/*"
                onchange="handleFileSelect(this, '{{isset($gallery) ?? $gallery->id}}')">
        </div>
    </div>
</div>

<!-- Contador e Lista de Arquivos -->
<div class="files-info mb-3" id="filesInfo" style="display: none;">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="badge bg-primary" id="fileCount">
            <i class="bx bx-images me-1"></i>0 arquivos selecionados
        </span>
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFiles('{{isset($gallery) ?? $gallery->id}}')">
            <i class="bx bx-trash me-1"></i>Limpar todos
        </button>
    </div>
    <div class="file-list" id="fileList">
        <!-- Lista de arquivos será inserida aqui -->
    </div>
</div>

<!-- Barra de Progresso (opcional) -->
<div class="progress mb-3" id="progressBar" style="display: none; height: 8px;">
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
        <span class="text-muted small" id="uploadHint">
            <i class="bx bx-info-circle me-1"></i>
            Nenhum arquivo selecionado
        </span>
    </div>
    <div>
        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">
            <i class="bx bx-x me-1"></i>Cancelar
        </button>
        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
            <i class="bx bx-upload me-1"></i>Enviar Arquivos
        </button>
    </div>
</div>

{{-- Upload multiplo --}}
<script>
    let selectedFiles = [];

    function handleFileSelect(input) {
        const files = Array.from(input.files);
        processFiles(files);
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

    function handleDrop(event) {
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
        processFiles(validFiles);
    }

    function processFiles(files) {
        const maxSize = 2 * 1024 * 1024;
        files.forEach(file => {
            if (!file.type.startsWith('image/')) {
                showNotification(`${file.name} não é uma imagem válida`, 'warning');
                return;
            }
            if (file.size > maxSize) {
                showNotification(`${file.name} excede 2MB`, 'error');
                return;
            }
            selectedFiles.push(file);
        });
        updateUI();
    }

    function updateUI() {
        const fileInput = document.getElementById('fileInput');
        const filesInfo = document.getElementById('filesInfo');
        const submitBtn = document.getElementById('submitBtn');
        const uploadHint = document.getElementById('uploadHint');
        const fileCount = document.getElementById('fileCount');
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        fileInput.files = dataTransfer.files;
        if (selectedFiles.length > 0) {
            filesInfo.style.display = 'block';
            submitBtn.disabled = false;
            const count = selectedFiles.length;
            fileCount.innerHTML = `
            <i class="bx bx-images me-1"></i>
            ${count} ${count === 1 ? 'arquivo' : 'arquivos'} selecionado${count === 1 ? '' : 's'}
        `;
            uploadHint.innerHTML = `
            <i class="bx bx-check-circle me-1"></i>
            ${count} ${count === 1 ? 'arquivo pronto' : 'arquivos prontos'} para upload
        `;
            uploadHint.className = 'text-success small';
            generatePreviews();
            generateFileList();
        } else {
            filesInfo.style.display = 'none';
            submitBtn.disabled = true;
            uploadHint.innerHTML = `
            <i class="bx bx-info-circle me-1"></i>
            Nenhum arquivo selecionado
        `;
            uploadHint.className = 'text-muted small';
            document.getElementById('previewContainer').innerHTML = '';
            document.getElementById('fileList').innerHTML = '';
        }
    }

    function generatePreviews() {
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = '';
        selectedFiles.slice(0, 6).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.innerHTML = `
                <img
                    src="${event.target.result}"
                    alt="Preview ${index + 1}"
                >

                <button
                    type="button"
                    class="remove-file"
                    onclick="removeFile(${index})"
                >
                    <i class="bx bx-x"></i>
                </button>
            `;
                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
        if (selectedFiles.length > 6) {
            const moreItem = document.createElement('div');
            moreItem.className = 'preview-item d-flex align-items-center justify-content-center bg-light';
            moreItem.innerHTML = `
            <span class="text-muted">
                +${selectedFiles.length - 6}
            </span>
        `;
            previewContainer.appendChild(moreItem);
        }
    }

    function generateFileList() {
        const fileList = document.getElementById('fileList');
        fileList.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            const icon = file.type.includes('image') ? 'bx bx-image' : 'bx bx-file';
            const size = (file.size / 1024).toFixed(1) + ' KB';
            fileItem.innerHTML = `
            <i class="${icon}"></i>

            <span
                class="file-name"
                title="${file.name}"
            >
                ${file.name}
            </span>

            <span class="file-size">
                ${size}
            </span>

            <span
                class="remove-single"
                onclick="removeFile(${index})"
            >
                <i class="bx bx-trash"></i>
            </span>
        `;
            fileList.appendChild(fileItem);
        });
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        updateUI();
    }

    function clearFiles() {
        selectedFiles = [];
        document.getElementById('fileInput').value = '';
        updateUI();
    }
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