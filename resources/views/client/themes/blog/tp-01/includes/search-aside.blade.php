<!-- Busca no Aside (White + Border) -->
<div class="card mb-4 rounded-0 col-12" style="background-color: rgb(254 245 240); border: 1px solid #e2e8f0;">
   <div class="card-body p-4">
      <h5 class="card-title fw-bold mb-3 fs-6 text-dark">
         <i class="bi bi-search me-2 text-dark"></i>Pesquisar no Blog
      </h5>
      <form action="/blog/busca" method="GET" class="position-relative">
         <div class="input-group">
            <input
               type="text"
               name="q"
               class="form-control rounded-pill ps-4 pe-5 py-2 border-0 shadow-none"
               style="background-color: #f8fafc;"
               placeholder="Digite o que procura..."
               required
               aria-label="Pesquisar no blog"
            >
            <button
               type="submit"
               class="btn bg-dark position-absolute top-50 end-0 translate-middle-y me-2 rounded-circle d-flex align-items-center justify-content-center"
               style="width: 35px; height: 35px; z-index: 10;"
               aria-label="Buscar"
            >
               <i class="bi bi-search text-white small"></i>
            </button>
         </div>
      </form>
   </div>
</div>

<style>
    .btn.bg-dark:hover {
        background: color-mix(in srgb, #000 85%, white 15%) !important;
    }
</style>