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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user')->unique(); 
            $table->string('name');
            $table->string('phone');
            $table->string('password');
    
            $table->string('consent_id1')->nullable(); // nivel tarjeta
            $table->string('consent_id2')->nullable(); // nivel cuenta
            $table->string('consent_id3')->nullable(); // nivel cuenta
    
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
        Schema::dropIfExists('users');
    }
};
