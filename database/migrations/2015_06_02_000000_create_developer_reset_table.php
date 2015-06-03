<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeveloperResetTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("developer_reset",
            function (Blueprint $table) {
                $table->string("email")->index();
                $table->string("token")->index();
                $table->timestamp("created_at");
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop("developer_reset");
    }
}
