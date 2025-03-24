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
        Schema::create('candidature', function (Blueprint $table) {
            $table->id();
            $table->text('cv');
            $table->text('coverletter');
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('annonce_id');
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('annonce_id')->references('id')->on('annonce');
            $table->foreign('candidate_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidature');
    }
};
