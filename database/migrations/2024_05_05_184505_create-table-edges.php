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
        Schema::create('edges', function (Blueprint $table) {
            //
            $table->id();
            $table->foreignId('start_node_id')->constrained('nodes');
            $table->foreignId('end_node_id')->constrained('nodes');
            $table->double('cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('edges', function (Blueprint $table) {
            //
        });
    }
};
