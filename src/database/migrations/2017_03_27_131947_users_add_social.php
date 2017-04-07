<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddSocial extends Migration
{
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->boolean('is_social')->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('is_social');
            $table->string('email')->change();
        });
    }
}