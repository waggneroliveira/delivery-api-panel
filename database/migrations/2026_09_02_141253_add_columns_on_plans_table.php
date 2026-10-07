<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            if (!Schema::hasColumn('plans', 'description')) {
                $table->string('description')->nullable();
            }

            if (!Schema::hasColumn('plans', 'text')) {
                $table->text('text')->nullable();
            }

            if (!Schema::hasColumn('plans', 'monthly_price')) {
                $table->decimal('monthly_price', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('plans', 'popular')) {
                $table->boolean('popular')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'text',
                'monthly_price',
                'popular',
            ]);
        });
    }
};