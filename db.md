Food Delivery Laravel Database Schema Reference
Updated Architecture: Single users table will be used for Admin, Customer, Restaurant, and Delivery Partner with role-based structure.

1.  Users Table
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
            'delivery_partner'
        ]);

        $table->string('profile_image')->nullable();

        // Common Fields
        $table->text('address')->nullable();
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();

        // Restaurant Specific Fields
        $table->string('restaurant_name')->nullable();
        $table->string('logo')->nullable();
        $table->time('opening_time')->nullable();
        $table->time('closing_time')->nullable();
        $table->decimal('commission_rate', 5, 2)->default(0);

        // Delivery Partner Fields
        $table->string('vehicle_type')->nullable();
        $table->string('vehicle_number')->nullable();
        $table->string('driving_license')->nullable();
        $table->enum('availability_status', ['online', 'offline'])->nullable();
        $table->decimal('earning_balance', 10, 2)->default(0);

        // Customer Fields
        $table->decimal('wallet_balance', 10, 2)->default(0);

        // Admin Fields
        $table->enum('admin_role', ['super_admin', 'sub_admin'])->nullable();

        $table->enum('status', ['active', 'inactive', 'pending'])->default('active');

        $table->rememberToken();
        $table->timestamps();

    });

---

3. Restaurant Categories Table
   Schema::create('restaurant_categories', function (Blueprint $table) {
   $table->id();
   $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
   $table->string('name');
   $table->string('image')->nullable();
   $table->enum('status', ['active', 'inactive'])->default('active');
   $table->timestamps();
   });

---

4. Menu Items Table
   Schema::create('menu_items', function (Blueprint $table) {
   $table->id();
   $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
   $table->foreignId('category_id')->constrained('restaurant_categories')->onDelete('cascade');
   $table->string('item_name');
   $table->text('description')->nullable();
   $table->string('image')->nullable();
   $table->decimal('price', 10, 2);
   $table->decimal('discount_price', 10, 2)->nullable();
   $table->integer('preparation_time')->nullable();
   $table->boolean('is_available')->default(true);
   $table->enum('status', ['active', 'inactive'])->default('active');
   $table->timestamps();
   });

---

6.  Orders Table
    Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('order_number')->unique();

        $table->foreignId('customer_id')->constrained()->onDelete('cascade');

        $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');

        $table->foreignId('delivery_partner_id')
              ->nullable()
              ->constrained()
              ->nullOnDelete();

        $table->decimal('subtotal', 10, 2);
        $table->decimal('delivery_charge', 10, 2)->default(0);
        $table->decimal('tax', 10, 2)->default(0);
        $table->decimal('discount', 10, 2)->default(0);
        $table->decimal('grand_total', 10, 2);

        $table->enum('payment_method', ['cod', 'online']);
        $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');

        $table->enum('order_status', [
            'pending',
            'accepted',
            'preparing',
            'picked',
            'delivered',
            'cancelled'
        ])->default('pending');

        $table->text('delivery_address');
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();

        $table->timestamps();

    });

---

7.  Order Items Table
    Schema::create('order_items', function (Blueprint $table) {
    $table->id();

        $table->foreignId('order_id')
              ->constrained()
              ->onDelete('cascade');

        $table->foreignId('menu_item_id')
              ->constrained()
              ->onDelete('cascade');

        $table->integer('quantity');
        $table->decimal('price', 10, 2);
        $table->decimal('total', 10, 2);

        $table->timestamps();

    });

---

8.  Payments Table
    Schema::create('payments', function (Blueprint $table) {
    $table->id();

        $table->foreignId('order_id')
              ->constrained()
              ->onDelete('cascade');

        $table->foreignId('customer_id')
              ->constrained()
              ->onDelete('cascade');

        $table->string('transaction_id')->nullable();
        $table->string('payment_gateway')->nullable();

        $table->decimal('amount', 10, 2);

        $table->enum('payment_status', [
            'success',
            'failed',
            'pending'
        ])->default('pending');

        $table->timestamp('paid_at')->nullable();

        $table->timestamps();

    });

---

9.  Coupons Table
    Schema::create('coupons', function (Blueprint $table) {
    $table->id();

        $table->string('coupon_code')->unique();

        $table->enum('discount_type', [
            'percentage',
            'flat'
        ]);

        $table->decimal('discount_value', 10, 2);

        $table->decimal('minimum_order_amount', 10, 2)->default(0);

        $table->date('expiry_date');

        $table->enum('status', [
            'active',
            'inactive'
        ])->default('active');

        $table->timestamps();

    });

---

10. Notifications Table
    Schema::create('notifications', function (Blueprint $table) {
    $table->id();

        $table->enum('user_type', [
            'customer',
            'restaurant',
            'delivery'
        ]);

        $table->unsignedBigInteger('user_id');

        $table->string('title');
        $table->text('message');

        $table->boolean('is_read')->default(false);

        $table->timestamps();

    });

---

11. Reviews Table
    Schema::create('reviews', function (Blueprint $table) {
    $table->id();

        $table->foreignId('order_id')
              ->constrained()
              ->onDelete('cascade');

        $table->foreignId('customer_id')
              ->constrained()
              ->onDelete('cascade');

        $table->foreignId('restaurant_id')
              ->constrained()
              ->onDelete('cascade');

        $table->integer('rating');

        $table->text('review')->nullable();

        $table->timestamps();

    });

---

Artisan Commands
php artisan make:model User -m
php artisan make:model RestaurantCategory -m
php artisan make:model MenuItem -m
php artisan make:model Order -m
php artisan make:model OrderItem -m
php artisan make:model Payment -m
php artisan make:model Coupon -m
php artisan make:model Notification -m
php artisan make:model Review -m

---

Run Migration
php artisan migrate

---

Recommended Packages
Purpose Package
API Authentication Laravel Sanctum
Role Permission Spatie Permission
Media Upload Spatie Media Library
Activity Log Spatie Activitylog
Firebase Notification Laravel Firebase
