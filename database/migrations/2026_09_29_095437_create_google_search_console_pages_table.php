<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('google_search_console_pages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            $table->date('start_date');
            $table->date('end_date');
            $table->string('page', 500);
            $table->unsignedBigInteger('clicks')->default(0);
            $table->unsignedBigInteger('impressions')->default(0);
            $table->decimal('ctr', 10, 6)->default(0);
            $table->decimal('position', 10, 2)->default(0);
            $table->timestamps();
            $table->unique(
                ['tenant_id', 'start_date', 'end_date', 'page'],
                'gsc_pages_unique'
            );

            $table->index(
                ['tenant_id', 'start_date', 'end_date'],
                'gsc_pages_period_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('google_search_console_pages');
    }
};