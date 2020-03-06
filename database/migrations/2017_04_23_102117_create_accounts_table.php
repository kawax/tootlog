<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->unsignedInteger('server_id');
            $table->foreign('server_id')
                  ->references('id')->on('servers');

            $table->unsignedInteger('account_id');
            $table->unsignedBigInteger('since_id')->nullable();
            $table->string('token');
            $table->string('username');
            $table->string('acct');
            $table->string('display_name');
            $table->boolean('locked');
            $table->timestamp('account_created_at')->nullable();
            $table->unsignedInteger('statuses_count');
            $table->unsignedInteger('following_count');
            $table->unsignedInteger('followers_count');
            $table->text('note');
            $table->string('url');
            $table->string('avatar');
            $table->string('avatar_static');
            $table->string('header');
            $table->string('header_static');

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
        Schema::dropIfExists('accounts');
    }
}
