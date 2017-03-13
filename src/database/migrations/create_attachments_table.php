<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateAttachmentsTable extends Migration
{
    protected $table_attachments;

    public function __construct()
    {
        $this->table_attachments = config('back-project.attachments.table');
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_attachments, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('original_name');
            $table->text('description')->nullable();
            $table->boolean('is_main')->default(false)->index();
            $table->integer('user_id')->nullable()->unsigned()->index();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
        });

        Schema::create('attachables', function(Blueprint $table) {
           $table->integer('attachment_id')->unsigned();
           $table->morphs('attachable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table_attachments);
    }
}
