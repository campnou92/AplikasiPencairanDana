<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('actor'); // username or system
            $table->string('action'); // created, updated, deleted, login, etc.
            $table->string('entity'); // Model class or entity name
            $table->string('entity_id')->nullable();
            $table->dateTime('timestamp');
            $table->json('before_after')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};

