<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglMasukToPerbaikanTable extends Migration
{
    public function up()
    {
        Schema::table('perbaikans', function (Blueprint $table) {
            $table->date('tgl_masuk')->nullable()->after('kendaraan_id');
        });
    }

    public function down()
    {
        Schema::table('perbaikans', function (Blueprint $table) {
            $table->dropColumn('tgl_masuk');
        });
    }
}