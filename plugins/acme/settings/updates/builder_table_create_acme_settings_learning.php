<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAcmeSettingsLearning extends Migration
{
    public function up()
    {
        Schema::create('acme_settings_learning', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('file')->nullable();
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            $table->string('price')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('iframe')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acme_settings_learning');
    }
}
