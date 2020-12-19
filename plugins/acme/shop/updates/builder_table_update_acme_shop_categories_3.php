<?php namespace Acme\Shop\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeShopCategories3 extends Migration
{
    public function up()
    {
        Schema::table('acme_shop_categories', function($table)
        {
            $table->boolean('is_cub')->nullable()->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('acme_shop_categories', function($table)
        {
            $table->dropColumn('is_cub');
        });
    }
}
