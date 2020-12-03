<?php namespace Acme\Settings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAcmeSettingsFeedback3 extends Migration
{
    public function up()
    {
        Schema::table('acme_settings_feedback', function($table)
        {
            $table->boolean('status')->nullable()->unsigned(false)->default(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('acme_settings_feedback', function($table)
        {
            $table->integer('status')->nullable()->unsigned(false)->default(0)->change();
        });
    }
}
