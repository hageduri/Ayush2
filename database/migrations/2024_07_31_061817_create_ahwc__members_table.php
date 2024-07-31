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
        Schema::create('ahwc__members', function (Blueprint $table) {
            $table->string('id', 26);
            $table->string('nin', 50);
            $table->string('name', 255);
            $table->string('gender', 20);
            $table->date('dob');
            $table->text('address')->nullable();
            $table->string('contact_1', 15);
            $table->string('contact_2', 15)->nullable();
            $table->string('email', 100)->unique();
            $table->string('designation', 50);
            $table->string('bank_name', 100);
            $table->string('account_no', 20);
            $table->string('ifsc_code', 11);
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahwc__members');
    }
};
