<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->references('id')->on('users');
            $table->foreignId('file')->references('id')->on('documents')->onDelete('cascade');
            $table->boolean('accepted')->nullable();
            $table->boolean('read')->nullable()->default(false);
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
        Schema::dropIfExists('file_requests');
    }
}
