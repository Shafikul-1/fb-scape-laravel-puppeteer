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
        Schema::table('collect_data', function (Blueprint $table) {
            $table->enum('status', ['complete', 'acrive', 'delete', 'noaction'])->default('noaction');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collect_data', function (Blueprint $table) {
            //
        });
    }
};
