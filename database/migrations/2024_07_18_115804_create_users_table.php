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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->nullable()->constrained('states')->cascadeOnDelete();
            $table->foreignId('region_id')->nullable()->constrained('regions')->cascadeOnDelete();
            $table->foreignId('mosque_id')->nullable()->constrained('mosques')->cascadeOnDelete();

            $table->string('name')->index();
            $table->string('id-number', 9)->index()->unique();
            $table->string('name-wife')->nullable()->index();
            $table->string('id-number-wife', 9)->nullable()->index()->unique();

            $table->date('barh-of-date')->nullable();
            $table->string('count_childern', 2)->nullable();
            $table->string('phone', 15)->index()->nullable();

            $table->string('phone2', 15)->index()->nullable();

            $table->enum('gender', ['male', 'fmale'])->nullable();
            $table->tinyInteger('socialst')->nullable();

            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_print')->default(false);

            $table->boolean('is_death')->default(false);
            $table->date('death_date')->nullable();



            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
