<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeSettingsFeedback4 extends Migration
{
    public function up()
    {
        Schema::table('acme_settings_feedback', function($table)
        {
            $table->string('time')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('acme_settings_feedback', function($table)
        {
            $table->dateTime('time')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
