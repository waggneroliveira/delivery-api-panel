<?php

namespace App\Http\Requests\Concerns;

trait NormalizesProductPrices
{
    protected function normalizeProductPrices(): array
    {
        $normalized = [];

        foreach (['price', 'old_price'] as $field) {
            if ($this->exists($field)) {
                $normalized[$field] = $this->normalizeMoneyInput(
                    $this->input($field)
                );
            }
        }

        $options = $this->input('options');

        if (is_array($options)) {
            foreach ($options as &$option) {
                if (!is_array($option) || !is_array($option['choices'] ?? null)) {
                    continue;
                }

                foreach ($option['choices'] as &$choice) {
                    if (is_array($choice) && array_key_exists('price', $choice)) {
                        $choice['price'] = $this->normalizeMoneyInput(
                            $choice['price']
                        );
                    }
                }
                unset($choice);
            }
            unset($option);

            $normalized['options'] = $options;
        }

        $addons = $this->input('combo_addons');

        if (is_array($addons)) {
            foreach ($addons as &$addon) {
                if (is_array($addon) && array_key_exists('price', $addon)) {
                    $addon['price'] = $this->normalizeMoneyInput(
                        $addon['price']
                    );
                }
            }
            unset($addon);

            $normalized['combo_addons'] = $addons;
        }

        return $normalized;
    }

    private function normalizeMoneyInput(mixed $value): mixed
    {
        if (!is_string($value) && !is_numeric($value)) {
            return $value;
        }

        $value = str_replace(
            ['R$', ' ', "\u{A0}"],
            '',
            trim((string) $value)
        );

        if (str_contains($value, ',')) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        }

        return $value;
    }

    protected function productCompositionRules(): array
    {
        return [
            'product_type' => ['nullable', 'in:food,combo'],
            'price' => ['required_with:product_type', 'nullable', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'options' => ['sometimes', 'array'],
            'options.*.title' => ['required', 'string', 'max:255'],
            'options.*.type' => ['required', 'in:single,multiple'],
            'options.*.max_selections' => ['nullable', 'integer', 'min:1'],
            'options.*.required' => ['nullable', 'boolean'],
            'options.*.choices' => ['sometimes', 'array'],
            'options.*.choices.*.id' => ['nullable', 'string', 'max:100'],
            'options.*.choices.*.name' => ['required', 'string', 'max:255'],
            'options.*.choices.*.price' => ['nullable', 'numeric', 'min:0'],
            'options.*.choices.*.description' => ['nullable', 'string', 'max:1000'],
            'options.*.choices.*.maxQuantity' => ['nullable', 'integer', 'min:1'],
            'options.*.choices.*.category' => ['nullable', 'string', 'max:255'],
            'options.*.choices.*.default' => ['nullable', 'boolean'],
            'options.*.choices.*.isRecommended' => ['nullable', 'boolean'],
            'combo_items' => ['sometimes', 'array'],
            'combo_items.*.name' => ['required', 'string', 'max:255'],
            'combo_items.*.quantity' => ['nullable', 'integer', 'min:1'],
            'combo_items.*.required' => ['nullable', 'boolean'],
            'combo_addons' => ['sometimes', 'array'],
            'combo_addons.*.name' => ['required', 'string', 'max:255'],
            'combo_addons.*.price' => ['nullable', 'numeric', 'min:0'],
            'combo_addons.*.max_quantity' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
