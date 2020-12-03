<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAcmeSettingsAdvantages extends Migration
{
    public function up()
    {
        Schema::create('acme_settings_advantages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 100)->nullable();
            $table->text('description')->nullable();
            $table->text('advantages')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acme_settings_advantages');
    }
}
