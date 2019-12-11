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
            // $table->unsignedBigInteger('team_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->integer('sticky_phone_number_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('fb_messenger_id')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('unsubscribed_status')->default('none');
            $table->timestamps();

            $table->index('phone', 'idx_phone_search');
            // $table->index(['team_id', 'phone'], 'idx_phone_search');
            // $table->index('team_id', 'contacts_team_id_index');
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
