<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_devices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('device_name',50)->nullable();
            $table->string('platform',50)->nullable();            
            $table->string('device_id',255)->nullable();
            $table->mediumText('push_token')->nullable();
            $table->string('app_version',15)->nullable();
            $table->string('os_version',15)->nullable();
            $table->string('time_zone',100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_devices');
    }
};
