<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class prodecrs extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prodecrs', function (Blueprint $table) {
            $table->id();
            $table->string('namessss');
            $table->string('emailll')->unique();
            $table->string('passwordd');
          
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodecrs');
        //
    }
};
