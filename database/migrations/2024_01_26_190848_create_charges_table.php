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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
        $table->string('name', 50)->notNull();
        $table->decimal('amount', 10, 2)->notNull();
        $table->date('date')->nullable();
        $table->unsignedBigInteger('payment_id');
        $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
