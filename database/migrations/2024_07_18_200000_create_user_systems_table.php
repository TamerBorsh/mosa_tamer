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
        Schema::create('user_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->nullable()->constrained('states')->cascadeOnDelete();
            $table->foreignId('region_id')->nullable()->constrained('regions')->cascadeOnDelete();
            $table->foreignId('institution_id')->nullable()->constrained()->onDelete('set null'); // ربط المستخدم بالمؤسسة

            $table->string('count_childern', 2)->nullable();
            $table->tinyInteger('socialst')->nullable();
            $table->string('street')->nullable();
            $table->string('phone', 15)->index()->nullable();
            $table->text('notes')->nullable();
            $table->text('notes_data')->nullable();

            $table->boolean('is_test')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_systems');
    }
};
