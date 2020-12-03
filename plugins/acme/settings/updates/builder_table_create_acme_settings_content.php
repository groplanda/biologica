<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAcmeSettingsContent extends Migration
{
    public function up()
    {
        Schema::create('acme_settings_content', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('link')->nullable();
            $table->text('image')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acme_settings_content');
    }
}
