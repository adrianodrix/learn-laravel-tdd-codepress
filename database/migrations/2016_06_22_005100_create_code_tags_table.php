<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCodeTagsTable extends Migration
{
    public function up()
    {
        Schema::create('codepress_tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('codepress_tags');
    }
}