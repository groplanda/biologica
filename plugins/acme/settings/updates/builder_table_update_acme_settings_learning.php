<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeSettingsLearning extends Migration
{
    public function up()
    {
        Schema::table('acme_settings_learning', function($table)
        {
            $table->dropColumn('file');
        });
    }
    
    public function down()
    {
        Schema::table('acme_settings_learning', function($table)
        {
            $table->string('file', 191)->nullable();
        });
    }
}
