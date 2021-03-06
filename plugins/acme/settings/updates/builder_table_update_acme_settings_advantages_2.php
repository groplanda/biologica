<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeSettingsAdvantages2 extends Migration
{
    public function up()
    {
        Schema::table('acme_settings_advantages', function($table)
        {
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('acme_settings_advantages', function($table)
        {
            $table->dropColumn('deleted_at');
        });
    }
}
