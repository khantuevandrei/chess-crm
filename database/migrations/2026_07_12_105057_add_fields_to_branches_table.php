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
        Schema::table('branches', function (Blueprint $table) {
            $table->string('type')->default('main')->after('name');
            $table->string('short_name')->nullable()->after('type');
            $table->date('opening_date')->nullable()->after('phone');
            $table->string('code')->nullable()->after('opening_date');
            $table->string('city')->nullable()->after('address');
            $table->string('email')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('email');
            $table->string('website')->nullable()->after('postal_code');
            $table->text('description')->nullable()->after('website');
            $table->integer('capacity')->nullable()->after('description');
            $table->integer('area')->nullable()->after('capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            //
        });
    }
};
