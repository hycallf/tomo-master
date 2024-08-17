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

// Isi migrasi dengan:
public function up()
{
    Schema::table('kendaraan', function (Blueprint $table) {
        $table->integer('maintenance_schedule_months')->default(3);
        $table->timestamp('last_maintenance_date')->nullable();
        $table->boolean('reminder_sent')->default(false);
        $table->timestamp('reminder_sent_at')->nullable();
    });
}

/**
     * Run the migrations.
     *
     * @return void
     */

public function down()
{
    Schema::table('kendaraan', function (Blueprint $table) {
        $table->dropColumn(['maintenance_schedule_months', 'last_maintenance_date', 'reminder_sent', 'reminder_sent_at']);
    });
}
};
