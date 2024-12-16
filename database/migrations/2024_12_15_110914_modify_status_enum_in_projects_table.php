<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('status', ['not_started', 'ongoing', 'completed', 'active'])
                  ->default('not_started')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('status', ['not_started', 'ongoing', 'completed'])
                  ->default('not_started')
                  ->change();
        });
    }
};
