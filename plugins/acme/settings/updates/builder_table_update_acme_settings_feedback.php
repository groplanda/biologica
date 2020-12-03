<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeSettingsFeedback extends Migration
{
    public function up()
    {
        Schema::table('acme_settings_feedback', function($table)
        {
            $table->string('email', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('acme_settings_feedback', function($table)
        {
            $table->dropColumn('email');
        });
    }
}
