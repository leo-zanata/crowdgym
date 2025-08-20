<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gyms', function (Blueprint $table) {
            $table->id();
            $table->string('gym_name', 100);
            $table->string('manager_name', 100);
            $table->string('gym_phone', 20);
            $table->string('manager_phone', 20);
            $table->string('email', 255)->unique();
            $table->string('cpf', 11)->unique();
            $table->string('zip_code', 8);
            $table->string('state', 2);
            $table->string('city', 100);
            $table->string('neighborhood', 100);
            $table->string('street', 100);
            $table->integer('number');
            $table->string('complement', 255)->nullable();
            $table->time('opening');
            $table->time('closing');
            $table->string('week_day', 50);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gyms');
    }
};