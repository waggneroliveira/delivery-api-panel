<?php

namespace Tests\Unit;

use App\Http\Requests\Concerns\NormalizesProductPrices;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class NormalizesProductPricesTest extends TestCase
{
    public function test_it_normalizes_brazilian_prices_in_product_composition(): void
    {
        $request = new class extends Request {
            use NormalizesProductPrices;

            public function normalizedPrices(): array
            {
                return $this->normalizeProductPrices();
            }
        };

        $request->replace([
            'price' => 'R$ 1.234,56',
            'old_price' => '99,90',
            'options' => [
                [
                    'choices' => [
                        ['name' => 'Grande', 'price' => '5,50'],
                    ],
                ],
            ],
            'combo_items' => [
                [
                    'name' => 'Refrigerante',
                    'options' => [
                        [
                            'choices' => [
                                ['name' => 'Cola', 'price' => '2,50'],
                            ],
                        ],
                    ],
                ],
            ],
            'combo_addons' => [
                ['name' => 'Extra', 'price' => '12,00'],
            ],
        ]);

        self::assertSame([
            'price' => '1234.56',
            'old_price' => '99.90',
            'options' => [
                [
                    'choices' => [
                        ['name' => 'Grande', 'price' => '5.50'],
                    ],
                ],
            ],
            'combo_items' => [
                [
                    'name' => 'Refrigerante',
                    'options' => [
                        [
                            'choices' => [
                                ['name' => 'Cola', 'price' => '2.50'],
                            ],
                        ],
                    ],
                ],
            ],
            'combo_addons' => [
                ['name' => 'Extra', 'price' => '12.00'],
            ],
        ], $request->normalizedPrices());
    }

    public function test_it_leaves_invalid_price_text_for_validation_to_reject(): void
    {
        $request = new class extends Request {
            use NormalizesProductPrices;

            public function normalizedPrices(): array
            {
                return $this->normalizeProductPrices();
            }
        };

        $request->replace(['price' => 'invalid']);

        self::assertSame(
            ['price' => 'invalid'],
            $request->normalizedPrices()
        );
    }
}
