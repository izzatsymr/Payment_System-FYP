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
        Schema::table('card_scanner', function (Blueprint $table) {
            $table
                ->foreign('scanner_id')
                ->references('id')
                ->on('scanners')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('card_id')
                ->references('id')
                ->on('cards')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_scanner', function (Blueprint $table) {
            $table->dropForeign(['scanner_id']);
            $table->dropForeign(['card_id']);
        });
    }
};
