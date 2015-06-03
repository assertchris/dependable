<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeveloperTableFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table("developer", function (Blueprint $table) {
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table("developer", function (Blueprint $table) {
            $table->dropColumn("remember_token");
        });
    }
}
