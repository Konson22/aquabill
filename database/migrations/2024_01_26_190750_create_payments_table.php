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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('tariff', 10, 2)->notNull();
            $table->decimal('amount', 10, 2)->notNull();
            $table->decimal('charges', 10, 2)->notNull();
            $table->decimal('remaining', 10, 2)->notNull();
            $table->decimal('paid', 10, 2)->notNull();
            $table->string('method', 255)->notNull();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('reading_id')->nullable();
        $table->foreign('reading_id')->references('id')->on('readings')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('description')->nullable();
            $table->string('status', 255)->notNull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
