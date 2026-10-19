<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\TemplateTheme;
use App\Models\Tenant;
use App\Models\TenantModuleLimit;
use Illuminate\Support\Str;

class ThemeManager
{
    /**
     * Retorna o tema atual do tenant.
     */
    public function theme(): ?TemplateTheme
    {
        return Tenant::current()?->templateTheme;
    }

    /**
     * Permite acessar diretamente propriedades do TemplateTheme.
     *
     * Exemplo:
     * $theme->slug
     * $theme->primary_color
     */
    public function __get($name)
    {
        return $this->theme()?->{$name};
    }

    /**
     * Retorna o slug do tema atual.
     *
     * Exemplo:
     * ecommerce
     * petshop
     * cartorio
     */
    public function current(): string
    {
        return $this->theme()?->slug ?? 'default';
    }

    /**
     * Retorna o tipo de layout atual.
     *
     * Exemplo:
     * onepage
     * multipage
     */
    public function layoutType(): string
    {
        return $this->theme()?->layout_type ?? 'onepage';
    }

    /**
     * Retorna a variação atual do template.
     *
     * Exemplo:
     * tp-01
     * tp-02
     */
    public function variation(): ?string
    {
        return $this->theme()?->template_variation ?? 'error';
    }

    /**
     * Retorna a configuração completa do template atual.
     *
     * Exemplo:
     * template_modules.ecommerce
     */
    public function templateConfig(): array
    {
        return config(
            "template_modules.{$this->current()}",
            []
        );
    }

    /**
     * Retorna a configuração específica do layout
     * e da variação atual.
     *
     * Exemplo:
     *
     * ecommerce
     * └── multipage
     *     └── tp-01
     */
    public function layoutConfig(): array
    {
        return config(
            "template_modules.{$this->current()}.{$this->layoutType()}.{$this->variation()}",
            []
        );
    }

    /**
     * Retorna o caminho da view core do tema.
     */
    public function core(string $view): string
    {
        return "client.themes.{$this->current()}.{$this->variation()}.core.{$view}";
    }

    /**
     * Retorna o caminho de uma view principal do tema.
     */
    public function view(string $view): string
    {
        return "client.themes.{$this->current()}.{$this->variation()}.blades.{$view}";
    }

    /**
     * Retorna o caminho de um include do tema.
     */
    public function includes(string $view): string
    {
        return "client.themes.{$this->current()}.{$this->variation()}.includes.{$view}";
    }

    /**
     * Retorna o caminho de um asset do tema.
     */
    public function asset(string $path): string
    {
        return asset("themes/{$this->current()}/{$path}");
    }

    /**
     * Retorna os módulos específicos do layout e
     * da variação atual.
     *
     * Exemplo:
     *
     * ecommerce
     * └── multipage
     *     └── tp-01
     *         ├── home
     *         ├── about
     *         ├── products
     *         └── contact
     */
    protected function layoutModules(): Collection
    {
        return collect($this->layoutConfig())
            ->flatten()
            ->filter(fn ($module) => is_string($module))
            ->unique()
            ->values();
    }

    /**
     * Retorna os módulos globais do template.
     *
     * Esses módulos não dependem de:
     * - onepage / multipage
     * - tp-01 / tp-02
     */
    protected function globalModules(): Collection
    {
        $templateModules = $this->templateConfig();

        return collect([
            'smtp',
            'security_and_access_control',
            'config_theme',
        ])
            ->flatMap(function ($section) use ($templateModules) {
                return $templateModules[$section] ?? [];
            })
            ->filter(fn ($module) => is_string($module))
            ->unique()
            ->values();
    }

    /**
     * Retorna todos os módulos disponíveis considerando:
     * - template
     * - layout
     * - variação
     * - módulos globais
     */
    public function modules(): Collection
    {
        return $this->layoutModules()
            ->merge($this->globalModules())
            ->unique()
            ->values();
    }

    /**
     * Retorna os módulos de uma página específica.
     *
     * Exemplo:
     *
     * $theme->pageModules('about');
     */
    public function pageModules(string $page): Collection
    {
        return collect(
            $this->layoutConfig()[$page] ?? []
        )
            ->filter(fn ($module) => is_string($module))
            ->unique()
            ->values();
    }

    /**
     * Verifica se uma página existe no layout e
     * variação atuais.
     *
     * IMPORTANTE:
     *
     * Isso verifica a existência da PÁGINA,
     * e não apenas do módulo.
     *
     * Exemplo:
     *
     * tp-01:
     *
     * 'home' => [
     *     'about',
     * ],
     *
     * 'about' => [
     *     'about',
     * ],
     *
     * Nesse caso:
     *
     * hasPage('about')  = true
     * hasModule('about') = true
     *
     * Já:
     *
     * 'home' => [
     *     'about',
     * ],
     *
     * Nesse caso:
     *
     * hasPage('about')  = false
     * hasModule('about') = true
     */
    public function hasPage(string $page): bool
    {
        return array_key_exists(
            $page,
            $this->layoutConfig()
        );
    }

    /**
     * Retorna todas as páginas disponíveis no
     * layout e variação atuais.
     *
     * Exemplo:
     *
     * [
     *     'home',
     *     'about',
     *     'products',
     *     'contact',
     * ]
     */
    public function pages(): Collection
    {
        return collect(
            array_keys($this->layoutConfig())
        );
    }

    /**
     * Verifica se o módulo existe no template atual,
     * considerando layout e variação.
     */
    public function hasModule(string $module): bool
    {
        return $this->modules()->contains($module);
    }

    /**
     * Verifica se pelo menos um dos módulos informados
     * existe no template atual.
     */
    public function hasAnyModule(array $modules): bool
    {
        foreach ($modules as $module) {
            if ($this->hasModule($module)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retorna o limite efetivo de um módulo.
     *
     * Prioridade:
     *
     * 1. Limite personalizado do tenant
     * 2. Limite definido no plano
     * 3. Limite definido no template_modules.php
     * 4. Valor default informado
     *
     * Exemplo:
     *
     * $theme->getLimit('slides');
     */
    public function getLimit(string $module, ?int $default = null): ?int
    {
        $tenant = Tenant::current();

        if (!$tenant) {
            return $default;
        }

        /*
        |--------------------------------------------------------------------------
        | 1. Limite personalizado do Tenant
        |--------------------------------------------------------------------------
        */

        $customLimit = TenantModuleLimit::query()
            ->where('tenant_id', $tenant->id)
            ->where('module', $module)
            ->value('limit');

        if ($customLimit !== null) {
            return (int) $customLimit;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Limite definido pelo Plano
        |--------------------------------------------------------------------------
        */

        if ($tenant->plan_id) {
            $planLimit = $tenant->plan
                ?->moduleLimits()
                ->where('module', $module)
                ->value('limit');

            if ($planLimit !== null) {
                return (int) $planLimit;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Limite definido no template_modules.php
        |--------------------------------------------------------------------------
        */

        $templateLimit = config(
            "template_modules.{$this->current()}.limits.{$module}"
        );

        if ($templateLimit !== null) {
            return (int) $templateLimit;
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Valor padrão
        |--------------------------------------------------------------------------
        */

        return $default;
    }

    /**
     * Retorna todos os módulos disponíveis no template atual,
     * considerando layout, variação e módulos globais.
     *
     * Não considera limites de tenant ou plano.
     *
     * Exemplo:
     *
     * [
     *     'about' => 'About',
     *     'slides' => 'Slides',
     *     'topics' => 'Topics',
     * ]
     */
    public function availableModules(): array
    {
        return $this->modules()
            ->sort()
            ->mapWithKeys(fn ($module) => [
                $module => Str::headline($module),
            ])
            ->toArray();
    }

    /**
     * Retorna o caminho de uma view de erro do tema.
     */
    public function error(string $view): string
    {
        return "client.themes.{$this->current()}.{$this->variation()}.errors.{$view}";
    }
}