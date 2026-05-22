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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('password');

            $table->enum('role', [
                'admin',
                'customer',
                'restaurant',
                'delivery_partner',
            ]);

            $table->string('profile_image')->nullable();

            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->string('restaurant_name')->nullable();
            $table->string('logo')->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(0);

            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('driving_license')->nullable();
            $table->enum('availability_status', ['online', 'offline'])->nullable();
            $table->decimal('earning_balance', 10, 2)->default(0);

            $table->decimal('wallet_balance', 10, 2)->default(0);

            $table->enum('admin_role', ['super_admin', 'sub_admin'])->nullable();

            $table->enum('status', ['active', 'inactive', 'pending'])->default('active');

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
