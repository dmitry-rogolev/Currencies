<?php

use App\Models\Load;
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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("num_code")->nullable();
            $table->string("char_code", 255)->collation("utf8mb4_bin")->nullable();
            $table->unsignedInteger("nominal")->nullable();
            $table->string("name", 255)->nullable();
            $table->unsignedDecimal("value")->nullable();
            $table->foreignIdFor(Load::class)->nullable();
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
        Schema::dropIfExists('currencies');
    }
};
