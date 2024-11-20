<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToSubscriptionListsTable extends Migration
{
    public function up()
    {
        Schema::table('subscription_lists', function (Blueprint $table) {
            $table->string('name')->unique();
        });
    }

    public function down()
    {
        Schema::table('subscription_lists', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
}