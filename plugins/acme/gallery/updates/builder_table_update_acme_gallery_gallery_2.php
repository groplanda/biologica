<?php namespace Acme\gallery\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeGalleryGallery2 extends Migration
{
    public function up()
    {
        Schema::table('acme_gallery_gallery', function($table)
        {
            $table->text('images')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('acme_gallery_gallery', function($table)
        {
            $table->dropColumn('images');
        });
    }
}
