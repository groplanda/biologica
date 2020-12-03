<?php namespace Acme\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAcmeShopProductsCategories extends Migration
{
    public function up()
    {
        Schema::create('acme_shop_products_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id');
            $table->smallInteger('category_id');
            $table->primary(['product_id','category_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acme_shop_products_categories');
    }
}
