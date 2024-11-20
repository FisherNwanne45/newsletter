<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionListIdToSubscribersTable extends Migration
{
    public function up()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            // Add the subscription_list_id column
            $table->unsignedBigInteger('subscription_list_id')->nullable()->after('id'); // After 'id' column
            $table->foreign('subscription_list_id')->references('id')->on('subscription_lists')->onDelete('cascade'); // Define the foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            // Drop the subscription_list_id column and foreign key
            $table->dropForeign(['subscription_list_id']);
            $table->dropColumn('subscription_list_id');
        });
    }
}