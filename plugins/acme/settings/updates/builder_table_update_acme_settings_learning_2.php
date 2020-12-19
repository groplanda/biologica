<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeSettingsLearning2 extends Migration
{
    public function up()
    {
        Schema::table('acme_settings_learning', function($table)
        {
            $table->integer('sort_order')->nullable()->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('acme_settings_learning', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
}
