<?php namespace Acme\gallery\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAcmeGalleryGallery extends Migration
{
    public function up()
    {
        Schema::create('acme_gallery_gallery', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acme_gallery_gallery');
    }
}
