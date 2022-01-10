<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taggables', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->string('taggable_type');
            $table->unsignedBigInteger('taggable_id');
            
            $table->unique(['tag_id', 'taggable_id', 'taggable_type'], 'taggables_tag_id_taggable_id_taggable_type_unique');
            $table->index(['taggable_type', 'taggable_id'], 'taggables_taggable_type_taggable_id_index');
            $table->foreign('tag_id', 'taggables_tag_id_foreign')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taggables');
    }
}
