<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Ubah kolom 'status' menjadi string
            $table->string('status')->default('not_started')->change();
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Kembalikan kolom 'status' menjadi enum jika dibutuhkan
            $table->enum('status', ['not_started', 'ongoing', 'completed'])
                  ->default('not_started')->change();
        });
    }
};
