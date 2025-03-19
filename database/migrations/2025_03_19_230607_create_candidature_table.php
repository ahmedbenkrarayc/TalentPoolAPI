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
            $table->string('status');
            $table->unsignedBigInteger('recruiter_id');
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('recruiter_id')->references('id')->on('users');
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
