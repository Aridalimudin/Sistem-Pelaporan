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
        Schema::create('reporters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('operation_id')->nullable();
            $table->string('code');
            $table->integer('rating')->nullable();
            $table->text('description');
            $table->text('comment')->nullable();
            $table->text('reason')->nullable();
            $table->text('reason_reject')->nullable();
            $table->text('file')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('urgency')->comment('1. Ringan 2.Sedang 3.Berat');
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
        Schema::dropIfExists('reporters');
    }
};
