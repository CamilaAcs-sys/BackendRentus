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
        Schema::create('rental_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('contract_id')
            ->references('id')
            ->on('contracts')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('property_id')
                ->references('id')
                ->on('properties')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_requests');
    }
};
