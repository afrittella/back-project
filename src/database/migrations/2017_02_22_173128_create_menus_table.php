<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateMenusTable extends Migration
{
    protected $table_menus;

    public function __construct()
    {
      $this->table_menus = config('back-project.menus.table');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_menus, function (Blueprint $table) {
          $table->increments('id');
          $table->string('name')->index();
          $table->string('permission')->nullable()->index();
          $table->string('title');
          $table->string('description')->nullable();
          $table->string('route')->nullable();
          $table->string('icon')->nullable();
          $table->boolean('is_active')->default(1);
            $table->boolean('is_protected')->default(0);
          NestedSet::columns($table);
          $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table_menus);
    }
}
