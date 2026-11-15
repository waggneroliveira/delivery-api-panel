<?php

namespace Tests\Unit;

use App\Http\Requests\ProductUpdateRequest;
use PHPUnit\Framework\TestCase;

class ProductUpdateRequestTest extends TestCase
{
    public function test_it_normalizes_unchecked_featured_checkbox_to_false(): void
    {
        $request = new class extends ProductUpdateRequest {
            public function prepare(): void
            {
                $this->prepareForValidation();
            }
        };

        $request->replace([]);
        $request->prepare();

        self::assertFalse($request->input('featured'));
    }

    public function test_it_normalizes_checked_featured_checkbox_to_true(): void
    {
        $request = new class extends ProductUpdateRequest {
            public function prepare(): void
            {
                $this->prepareForValidation();
            }
        };

        $request->replace(['featured' => '1']);
        $request->prepare();

        self::assertTrue($request->input('featured'));
    }
}
