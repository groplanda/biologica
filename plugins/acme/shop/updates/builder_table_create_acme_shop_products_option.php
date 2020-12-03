<?php namespace Acme\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAcmeShopProductsOption extends Migration
{
    public function up()
    {
        Schema::create('acme_shop_products_option', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id');
            $table->integer('option_id');
            $table->primary(['product_id','option_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acme_shop_products_option');
    }
}
