<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReblogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reblogs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('status_id');
            $table->string('acct');
            $table->string('display_name');
            $table->string('account_url');
            $table->string('avatar');

            $table->text('content');
            $table->timestampTz('created_at');
            $table->string('uri')->unique();
            $table->string('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reblogs');
    }
}
