<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSpoilerText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statuses', function (Blueprint $table) {
            $table->string('spoiler_text')->after('content')->nullable();
        });

        Schema::table('reblogs', function (Blueprint $table) {
            $table->string('spoiler_text')->after('content')->nullable();
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
            $table->dropColumn('spoiler_text');
        });

        Schema::table('reblogs', function (Blueprint $table) {
            $table->dropColumn('spoiler_text');
        });
    }
}
