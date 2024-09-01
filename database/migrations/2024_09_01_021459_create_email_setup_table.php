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
        Schema::create('email_setup', function (Blueprint $table) {
            $table->id();
            $table->string('email_transport');
            $table->string('email_host');
            $table->integer('email_port');
            $table->string('email_username');
            $table->string('email_password');
            $table->string('email_encryption');
            $table->string('email_from');
            $table->string('email_sender_name');
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_setup');
    }
};
