<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_sections', function (Blueprint $table) {
            $table->string('path_image')->nullable()->after('section');
        });
    }


    public function down(): void
    {
        Schema::table('service_sections', function (Blueprint $table) {
            $table->dropColumn('path_image');
        });
    }
};
