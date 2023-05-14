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
        Schema::create('answers_options', function (Blueprint $table) {
            $table->unsignedBigInteger('answer_id');
            $table->foreign('answer_id')
                ->references('id')
                ->on('answers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')
                ->references('id')
                ->on('options')
                ->onUpdate('cascade')
                ->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers_options');
    }
};
