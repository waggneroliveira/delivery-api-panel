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
        if (!Schema::hasColumn('service_sections', 'btn_title')) {
            Schema::table('service_sections', function (Blueprint $table) {
                $table->string('btn_title')->nullable();
            });
        }

        if (!Schema::hasColumn('service_sections', 'link')) {
            Schema::table('service_sections', function (Blueprint $table) {
                $table->string('link')->nullable();
            });
        }

        if (!Schema::hasColumn('service_sections', 'title_first_image')) {
            Schema::table('service_sections', function (Blueprint $table) {
                $table->string('title_first_image')->nullable();
            });
        }

        if (!Schema::hasColumn('service_sections', 'description_first_image')) {
            Schema::table('service_sections', function (Blueprint $table) {
                $table->text('description_first_image')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_sections', function (Blueprint $table) {
            $table->dropColumn([
                'btn_title',
                'link',
                'title_first_image',
                'description_first_image',
            ]);
        });
    }
};
