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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references( coloumns: 'id')->on( table: 'users');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references( coloumns: 'id')->on( table: 'users');
            $table->unsignedBigInteger('deleted_by')->nullable(); // Allow null values
            $table->foreign('deleted_by')->references( coloumns: 'id')->on( table: 'users');
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
