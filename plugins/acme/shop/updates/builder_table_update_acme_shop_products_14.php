<?php namespace Acme\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeShopProducts14 extends Migration
{
    public function up()
    {
        Schema::table('acme_shop_products', function($table)
        {
            $table->dropColumn('rating');
        });
    }
    
    public function down()
    {
        Schema::table('acme_shop_products', function($table)
        {
            $table->integer('rating')->nullable();
        });
    }
}
