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
        Schema::create('email_sender', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->text('email_subject');
            $table->timestamp('sending_time');
            $table->enum('email_status', ['wrong', 'pending', 'success', 'no action'])->default('no action');
            $table->longText('email_body');
            $table->text('email_files')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_sender');
    }
};
