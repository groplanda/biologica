<?php namespace Acme\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeShopProducts10 extends Migration
{
    public function up()
    {
        Schema::table('acme_shop_products', function($table)
        {
            $table->boolean('is_iframe')->nullable()->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('acme_shop_products', function($table)
        {
            $table->dropColumn('is_iframe');
        });
    }
}
