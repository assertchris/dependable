<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeveloperTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("developer", function (Blueprint $table) {
            $table->increments("id");
            $table->string("github_id");
            $table->string("github_name");
            $table->string("github_nickname");
            $table->string("github_email");
            $table->string("github_avatar");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists("developer");
    }
}
