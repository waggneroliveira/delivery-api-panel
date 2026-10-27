
<div class="card">
    <div class="card-body">
        <div class="p-lg-1">
            <div class="mt-2">
                <h4 class="mt-0 mb-2 font-weight-semibold">Personalizando a paleta de cores
                </h4>
                <p>Você pode alterar a paleta de cores de qualquer demonstração facilmente, simplesmente alterando os valores de algumas variáveis ​​scss.</p>
                <p class="mb-0">Para modificar as cores em temas existentes, abra o <code>_variables-default.scss</code> arquivo 
                    <code>src/assets/scss/config/&lt;DEMO_NAME&gt;</code> e altere qualquer variável nele. Suas alterações serão refletidas automaticamente em quaisquer componentes ou elementos baseados em bootstrap. Observe que isso requer que você configure e execute o gulp flow fornecido nas etapas de instalação anteriores.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="p-lg-1">
            <h4 class="mb-2 mt-0 font-weight-semibold">Layouts integrados</h4>

            <p>O painel gerenciador de conteúdo fornece várias opções quando se trata de layout. Há várias opções de layout disponíveis. Ou seja, Vertical (navegação principal na "Esquerda"), Horizontal (navegação principal no "Topo") e Destacado. Você pode usar facilmente qualquer um deles simplesmente alterando algumas parciais e usando atributos de dados no <code>html</code> elemento.
            </p>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="p-lg-1">
            <h4 class="mb-2 mt-0 font-weight-semibold">Personalizando o modo de cor, Sidenav, Topbar e largura do layout</h4>
            <p>O painel permite que você tenha um sidenav esquerdo personalizado, largura geral do layout ou menu da barra superior. Você pode transformar a barra lateral esquerda em tamanho, tema (aparência) e tamanho diferentes. Você pode personalizá-la especificando o atributo de dados de layout (<code>data-*={}</code>) no <code>html</code>
            elemento em seu html. As propriedades do objeto de configuração aceitam os seguintes valores:</p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Opções</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code class="text-nowrap">data-bs-theme</code></td>
                            <td>String</td>
                            <td>"dark" | "light"</td>
                            <td>Changes overall color scheme to dark</td>
                        </tr>
                        <tr>
                            <td><code class="text-nowrap">data-layout</code></td>
                            <td>String</td>
                            <td>"vertical" | "horizontal" | "two-column" </td>
                            <td>Changes overall layout Style. By default, it would be set to vertical (<code>*</code> Changes in partials)</td>
                        </tr>
                        <tr>
                            <td><code class="text-nowrap">data-layout-width</code></td>
                            <td>String</td>
                            <td>"fluid" | "boxed"</td>
                            <td>Changes the Content width of overall layout</td>
                        </tr>
                        <tr>
                            <td><code class="text-nowrap">data-topbar-color</code></td>
                            <td>String</td>
                            <td>"dark" | "light" | "brand"</td>
                            <td>Changes topbar color scheme to dark or light</td>
                        </tr>
                        <tr>
                            <td><code class="text-nowrap">data-menu-color</code></td>
                            <td>String</td>
                            <td>"light" | "dark" | "brand" | "gradient"</td>
                            <td>the Menu color scheme. By default, it would be set to default
                                (light)
                            </td>
                        </tr>
                        <tr>
                            <td><code class="text-nowrap">data-menu-icon</code></td>
                            <td>String</td>
                            <td>"default" | "twotone"</td>
                            <td>the Menu Icon Tone. By default, it would be set to default</td>
                        </tr>
                        <tr>
                            <td><code class="text-nowrap">data-sidenav-size</code></td>
                            <td>String</td>
                            <td>"default" | "compact" | "condensed" | "full" | "fullscreen"</td>
                            <td>Changes overall Sidenav Width. <br> (<code>*</code> Only available in Sidenav Menu)</td>
                        </tr>
                        <tr>
                            <td><code class="text-nowrap">data-layout-mode</code></td>
                            <td>String</td>
                            <td>"default" | "detached"</td>
                            <td>Changes overall layout mode <br> (<code>*</code> Available in Sidenav & Tow Colum Sidebar Menu)</td>
                        </tr>
                        <tr>
                            <td><code class="text-nowrap">data-sidenav-user</code></td>
                            <td>Boolean</td>
                            <td>"true" | "false"</td>
                            <td>Indicates whether to show Sidenav on opening up the page. <br> (<code>*</code> Only available in Sidenav Menu)</td>
                        </tr>
                        <tr>
                            <td><code class="text-nowrap">data-two-column-color</code></td>
                            <td>String</td>
                            <td>"light" | "dark" | "brand" | "gradient"</td>
                            <td>the Two Colum Icon Menu color scheme. By default, it would be set to default (light) <br> (<code>*</code> Only available in Two Column Sidebar Menu)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="p-lg-1">
            <h4 class="mb-2 mt-0 font-weight-semibold">Customizando o tema via Head.JS (path: <code>assets/js/head.js</code>)</h4>
            <p>Você pode substituir o tema padrão através de <code>defaultConfig</code> no <code>head.js</code> </p>

<pre>
<span class="text-danger">
<span class="text-dark">//  Default Config Value</span>
var defaultConfig = {
theme: "light",          <span class="text-dark">// "dark" | "light"</span>

layout: {
mode: "default",     <span class="text-dark">// "default" | "detached"</span>
width: "fluid",      <span class="text-dark">// "fluid" | "boxed"</span>
},

topbar: {
color: "light",     <span class="text-dark">// "light" | "dark" | "brand"</span>
},

menu: {
color: "light",     <span class="text-dark">// "light" | "dark" | "brand" | "gradient" </span>
icon: "default",    <span class="text-dark">// "default" | "twotone" </span>
}, 

<span class="text-dark">// This option for only vertical (left Sidebar) layout</span>
sidenav: {
size: "default",     <span class="text-dark">// "default" | "compact" | "condensed" | "full" | "fullscreen" </span>
twocolumn: "light",  <span class="text-dark">// "light" | "dark" | "brand" | "gradient" </span>
user: false,         <span class="text-dark">// "true" | "false" </span>
},
};
</span>
</pre>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="mb-2 mt-0 font-weight-semibold">Criando Seeder</h4>
        <h5 class="mt-0 mb-2 font-weight-semibold">Estrutura</h5>
        <pre>
    
├── database
│   └── seeders
│   │   └── settingThemeSeeder.php

                    
        </pre>
        <p>As configurações iniciais do tema são criadas através do seeder <code>SettingThemeSeeder.php</code>. Este seeder é responsável por preencher o banco de dados com as definições necessárias para o tema e é chamado no <code>DatabaseSeeder.php</code> para garantir que as configurações sejam aplicadas durante a inicialização do banco de dados.</p>

        <pre>
DB::table('setting_themes')->insert([
    'user_id' => User::first()->id,
    'data_bs_theme' => 'dark',
    'data_layout_width' => 'default',
    'data_layout_mode' => 'detached',
    'data_topbar_color' => 'light',
    'data_menu_color' => 'light',
    'data_two_column_color' => 'light',
    'data_menu_icon' => 'default',
    'data_sidenav_size' => 'condensed',
    'created_at' => now()
]);

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(1)->create();

        $this->call([
            SettingThemeSeeder::class,
        ]);
        
    }
}
        </pre>
        <p>
            Essas configurações são utilizadas na blade <code>admin.blade.php</code> para que possam refletir o layout no painel. Exemplo:
        </p>

        @verbatim
            <pre>
{{ isset($settingTheme) ? $settingTheme->data_bs_theme : 'light' }}
            </pre>
        @endverbatim

        <p>
            A mudança de estilo se dar através de um <code>Ajax</code> que está no arquivo <code>main.js</code>
        </p>

        <pre>
├── resources
│   └── assets
│   │   └── admin
│   │   │  └── js
│   │   │  │   └── main.js              
        </pre>
    </div>
</div>