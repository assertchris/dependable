<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("repository", function (Blueprint $table) {
            $table->increments("id");
            $table->string("label")->nullable();
            $table->string("github_name");
            $table->string("is_active")->default(false);
            $table->integer("developer_id");
            $table->timestamps();

            $table->foreign("developer_id")
                ->references("id")->on("developer")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists("repository");
    }
}
