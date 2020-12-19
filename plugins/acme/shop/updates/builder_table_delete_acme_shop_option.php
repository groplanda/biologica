<?php namespace Acme\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteAcmeShopOption extends Migration
{
    public function up()
    {
        Schema::dropIfExists('acme_shop_option');
    }
    
    public function down()
    {
        Schema::create('acme_shop_option', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title', 191)->nullable();
            $table->string('type', 191)->nullable();
            $table->text('values')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
}
