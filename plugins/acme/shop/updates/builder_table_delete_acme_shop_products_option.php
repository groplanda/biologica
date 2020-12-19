<?php namespace Acme\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteAcmeShopProductsOption extends Migration
{
    public function up()
    {
        Schema::dropIfExists('acme_shop_products_option');
    }
    
    public function down()
    {
        Schema::create('acme_shop_products_option', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id');
            $table->integer('option_id');
            $table->primary(['product_id','option_id']);
        });
    }
}
