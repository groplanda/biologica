<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAcmeSettingsService extends Migration
{
    public function up()
    {
        Schema::create('acme_settings_service', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('services')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acme_settings_service');
    }
}
