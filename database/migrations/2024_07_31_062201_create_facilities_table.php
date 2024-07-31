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
        Schema::create('facilities', function (Blueprint $table) {
            $table->string('id', 26);
            $table->string('nin', 50)->unique();
            $table->date('proposed_date')->nullable();
            $table->string('name', 255);
            $table->string('facility_type', 50);
            $table->string('block_id', 26);
            $table->string('incharge', 26)->nullable();
            $table->string('status', 26)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
