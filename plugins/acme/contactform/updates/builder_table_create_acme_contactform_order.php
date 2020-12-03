<?php namespace Acme\Contactform\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAcmeContactformOrder extends Migration
{
    public function up()
    {
        Schema::create('acme_contactform_order', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('user_name')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_mail')->nullable();
            $table->text('user_message')->nullable();
            $table->string('user_ip')->nullable();
            $table->smallInteger('user_status')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acme_contactform_order');
    }
}
