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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255)->notNull();
            $table->string('last_name', 255)->notNull();
            $table->integer('phone')->nullable();
            $table->integer('credit')->nullable();
            $table->string('email', 255)->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('meter_id')->nullable();
            $table->integer('contract')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('meter_id')->references('id')->on('meters')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
