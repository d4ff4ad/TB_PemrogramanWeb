<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('phone_number');
            $table->integer('age')->nullable()->after('gender');
            $table->string('status_peserta')->nullable()->after('age'); // umum, mahasiswa, pelajar, jamaah_tetap
            $table->boolean('previous_participation')->default(false)->after('status_peserta');
            $table->text('special_needs')->nullable()->after('previous_participation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['gender', 'age', 'status_peserta', 'previous_participation', 'special_needs']);
        });
    }
};
