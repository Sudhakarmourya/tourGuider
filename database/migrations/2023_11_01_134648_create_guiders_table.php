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
        Schema::create('guiders', function (Blueprint $table) {
            $table->id();
            $table->string('gname');
            $table->string('gemail');
            $table->string('gphone');
            $table->string('ggender');
            $table->string('gid_proof');
            $table->string('gid_number');
            $table->string('gqualification');
            $table->string('gaddress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guiders');
    }
};
