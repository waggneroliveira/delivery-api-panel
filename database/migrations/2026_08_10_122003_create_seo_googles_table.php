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
        Schema::create('seo_googles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tenant_id')
                ->constrained('tenants')
                ->cascadeOnDelete();

            // SEO principal
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();

            // Imagens
            $table->string('social_image')->nullable();
            $table->string('favicon')->nullable();

            // Organização
            $table->string('organization_name')->nullable();
            $table->string('legal_name')->nullable();
            $table->string('organization_url')->nullable();
            $table->string('organization_logo')->nullable();
            $table->text('organization_description')->nullable();

            $table->date('founding_date')->nullable();

            // Contato
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();

            // Endereço
            $table->string('street_address')->nullable();
            $table->string('address_locality')->nullable();
            $table->string('address_region')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address_country')->nullable();

            // Atendimento
            $table->string('contact_type')->nullable();
            $table->string('area_served')->nullable();
            $table->json('available_languages')->nullable();

            // Funcionamento
            $table->json('opening_hours')->nullable();

            // Institucional
            $table->string('slogan')->nullable();
            $table->text('organization_keywords')->nullable();

            $table->timestamps();

            $table->unique('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_googles');
    }
};
