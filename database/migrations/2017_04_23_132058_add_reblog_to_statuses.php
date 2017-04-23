<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReblogToStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('reblog_id')->nullable();
            $table->foreign('reblog_id')
                  ->references('id')->on('reblogs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statuses', function (Blueprint $table) {
            $table->dropForeign(['reblog_id']);
            $table->dropColumn('reblog_id');

        });
    }
}
