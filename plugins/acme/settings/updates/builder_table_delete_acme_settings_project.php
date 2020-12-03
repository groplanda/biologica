<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteAcmeSettingsProject extends Migration
{
    public function up()
    {
        Schema::dropIfExists('acme_settings_project');
    }
    
    public function down()
    {
        Schema::create('acme_settings_project', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title', 191)->nullable();
            $table->string('square', 191)->nullable();
            $table->string('type', 191)->nullable();
            $table->text('description')->nullable();
            $table->string('photo', 191)->nullable();
            $table->boolean('is_active')->nullable()->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
}
