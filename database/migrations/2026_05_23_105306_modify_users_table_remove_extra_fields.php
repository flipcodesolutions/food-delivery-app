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
        Schema::table('users', function (Blueprint $table) {

            // Drop unwanted columns
            $table->dropColumn([
                'address',
                'latitude',
                'longitude',
                'restaurant_name',
                'logo',
                'opening_time',
                'closing_time',
                'commission_rate',
                'vehicle_type',
                'vehicle_number',
                'driving_license',
                'availability_status',
                'earning_balance',
                'wallet_balance',
                'admin_role'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Restore columns (rollback support)
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
        });
    }
};
