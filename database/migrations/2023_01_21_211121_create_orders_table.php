<?php

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $orderStatus = collect(OrderStatusEnum::cases())->map(fn($el) => $el->value)->toArray();
        $paymentStatus = collect(PaymentStatusEnum::cases())->map(fn($el) => $el->value)->toArray();

        Schema::create('orders', function (Blueprint $table) use ($orderStatus, $paymentStatus) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->float('price')->default(0);
            $table->integer('count_items')->default(0);
            $table->enum('order_status', $orderStatus)->default(OrderStatusEnum::CREATED->value);
            $table->enum('payment_status', $paymentStatus)->default(PaymentStatusEnum::UNPAID->value);
            $table->date('payment_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->date('canceled_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
