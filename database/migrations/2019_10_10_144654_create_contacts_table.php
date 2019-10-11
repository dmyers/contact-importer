<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->unsignedInteger('team_id');
            $table->string('first_name', 191)->nullable();
            $table->string('last_name', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('phone', 191);
            $table->integer('sticky_phone_number_id')->nullable();
            $table->string('twitter_id', 191)->nullable();
            $table->string('fb_messenger_id', 191)->nullable();
            $table->string('time_zone', 191)->nullable();
            $table->string('unsubscribed_status', 191)->default('none');
            $table->nullableTimestamps();

            $table->index(['team_id', 'phone'], 'idx_phone_search');
            $table->index('team_id', 'contacts_team_id_index');
            $table->index('first_name', 'contacts_first_name_index');
            $table->index('last_name', 'contacts_last_name_index');
            $table->index('phone', 'contacts_phone_index');
            $table->index('email', 'contacts_email_index');
            $table->index('twitter_id', 'contacts_twitter_id_index');
            $table->index('fb_messenger_id', 'contacts_fb_messenger_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
