<?php namespace Acme\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAcmeShopOrders extends Migration
{
    public function up()
    {
        Schema::create('acme_shop_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->string('ip')->nullable();
            $table->text('products')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_email')->nullable();
            $table->text('user_comment')->nullable();
            $table->string('user_adress')->nullable();
            $table->string('user_payment_method')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acme_shop_orders');
    }
}
