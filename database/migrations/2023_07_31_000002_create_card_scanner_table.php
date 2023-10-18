<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_scanner', function (Blueprint $table) {
            $table->unsignedBigInteger('scanner_id');
            $table->unsignedBigInteger('card_id');
            $table->enum('is_success', ['yes','no']);

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
        Schema::dropIfExists('card_scanner');
    }
};
