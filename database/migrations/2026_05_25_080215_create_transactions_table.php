<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();

            $table->date('date');

            $table->foreignId('coa_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->text('description')->nullable();

            $table->double('debit')->default(0);

            $table->double('credit')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};