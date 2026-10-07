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
        Schema::create('impact_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')
            ->constrained('tenants')
            ->cascadeOnDelete();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('content_title')->nullable();
            $table->text('content_text')->nullable();
            $table->string('path_image')->nullable();
            $table->integer('sorting')->default(0);
            $table->boolean('active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impact_sections');
    }
};
