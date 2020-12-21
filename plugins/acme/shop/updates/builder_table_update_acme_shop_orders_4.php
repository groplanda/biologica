<?php namespace Acme\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeShopOrders4 extends Migration
{
    public function up()
    {
        Schema::table('acme_shop_orders', function($table)
        {
            $table->text('order_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('acme_shop_orders', function($table)
        {
            $table->dropColumn('order_id');
        });
    }
}
