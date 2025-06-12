<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crimes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Bullying Verbal', 'Bullying Fisik', 'Pelecehan Seksual Verbal', 'Pelecehan Seksual Fisik']);
            $table->tinyInteger('urgency')->comment('1. Ringan 2.Sedang 3.Berat');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crimes');
    }
};
