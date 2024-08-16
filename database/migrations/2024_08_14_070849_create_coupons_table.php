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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained()->onDelete('cascade'); // ربط الكوبونات بالمؤسسة
            $table->foreignId('location_id')->constrained()->onDelete('cascade'); // ربط الكوبونات بالمخزن
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->string('name', 191)->index();
            $table->integer('quantity')->index(); // كمية الكوبونات
            $table->text('type')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
