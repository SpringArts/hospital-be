<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table){
            Schema::disableForeignKeyConstraints();
            DB::table('users')->truncate();
            Schema::enableForeignKeyConstraints();
            $data = [
                [
                    'id' => 1,
                    'name' => "Admin",
                    'email' => 'admin@gmail.com',
                    'password' => Hash::make('password'),
                    'email_verified_at' => Carbon::now(),
                    'email_verification_token' => "admin_autopass",
                    'role' => 'admin',
                    'is_active' => true
                ],
                [
                    'id' => 2,
                    'name' => "User",
                    'email' => 'user@gmail.com',
                    'password' => Hash::make('password'),
                    'email_verified_at' => Carbon::now(),
                    'email_verification_token' => "test_user",
                    'role' => 'guest',
                    'is_active' => true
                ],
            ];
            DB::table('users')->insert($data);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            DB::table('users')->truncate();
            Schema::enableForeignKeyConstraints();
        });
    }
};
