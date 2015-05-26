<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('slack_user_id');
            $table->string('slack_channel_id');
            $table->string('slack_channel_name');
            $table->string('name');
            $table->string('pin', 4);
            $table->json('options');
            $table->boolean('active')->default(false);
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
        Schema::drop('polls');
    }

}
