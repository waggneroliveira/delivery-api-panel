<div class="left-sidebar col-2">
    <div class="slimscroll-menu">
        <div class="list-group list-group-transparent mb-0">

            <span class="list-group-item disabled">               
                Começando
            </span>

            <a href="#introduction" class="list-group-item list-group-item-action active">
                <span class="mr-2">
                    <i class="mdi mdi-flag-variant-outline"></i>
                </span>Introdução
            </a>

            <a href="#setup" class="list-group-item list-group-item-action ">
                <span class="mr-2">
                    <i class="mdi mdi-apps"></i>
                </span>Configurar
            </a>

            <span class="list-group-item disabled">
                Segurança e Controle de Acesso
            </span>

            <a href="#audit" class="list-group-item list-group-item-action ">
                <span class="mr-2">
                    <i class="mdi mdi-square-edit-outline"></i>
                </span>Auditoria
            </a>
            <a href="#group-permission" class="list-group-item list-group-item-action ">
                <span class="mr-2">
                    <i class="mdi mdi-square-edit-outline"></i>
                </span>Grupos de permissões
            </a>


            <span class="list-group-item disabled">
                Customização
            </span>

            <a href="#customization" class="list-group-item list-group-item-action ">
                <span class="mr-2">
                    <i class="mdi mdi-widgets"></i>
                </span>Configuração do Tema
            </a>

            <a href="changelog.html" class="list-group-item list-group-item-action ">
                <span class="mr-2">
                    <i class="mdi mdi-book-open-page-variant"></i>
                </span>Changelog
            </a>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Seleciona todos os itens de navegação (links)
        const navItems = document.querySelectorAll('.list-group-item');
        
        // Função para ocultar todos os conteúdos
        function hideAllContents() {
            const contents = document.querySelectorAll('.page-content');
            contents.forEach(content => {
                content.style.display = 'none'; // Oculta o conteúdo
            });
        }

        // Função para remover a classe 'active' de todos os itens de navegação
        function removeActiveClass() {
            navItems.forEach(item => {
                item.classList.remove('active');
            });
        }

        // Função para exibir o conteúdo com base no id
        function showContentById(id) {
            hideAllContents(); // Oculta todos os conteúdos
            const contentToShow = document.getElementById(id);
            if (contentToShow) {
                contentToShow.style.display = 'block'; // Exibe o conteúdo específico
            }
        }

        // Adiciona o evento de clique em cada item da navbar
        navItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault(); // Evita a navegação padrão

                // Verifica se o href existe e contém '#'
                const href = this.getAttribute('href');
                if (href && href.includes('#')) {
                    // Recupera o id do conteúdo a ser exibido
                    const targetId = href.split('#')[1];

                    // Remove a classe 'active' de todos os itens de navegação
                    removeActiveClass();

                    // Adiciona a classe 'active' ao item clicado
                    this.classList.add('active');

                    // Chama a função para exibir o conteúdo correspondente
                    showContentById(targetId);
                } else {
                    console.error('Link inválido ou sem ID no href.');
                }
            });
        });

        // Oculta todos os conteúdos ao carregar a página, exceto o "introduction"
        hideAllContents();
        const introductionItem = document.querySelector('a[href$="#introduction"]');
        if (introductionItem) {
            const introductionId = introductionItem.getAttribute('href').split('#')[1];
            showContentById(introductionId); // Exibe o conteúdo de "introduction" ao carregar a página
            introductionItem.classList.add('active'); // Adiciona a classe 'active' ao item "introduction"
        }
    });
</script>
