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
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->bigInteger('total_pay');
            $table->integer('status',0)->comment('0 = Belum Bayar','1 = Sudah Bayar','2 = Sudah Dikirim','3 = Sudah Diterima','4 = Dibatalkan, 5 = Kadaluarsa');
            $table->integer('metode_pembayaran')->comment('0 = pembayaran manual','1 = midtrans')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('recipient_name');
            $table->string('snap_token')->nullable();
            $table->string('destination');
            $table->string('address_detail');
            $table->string('courier');
            $table->string('subtotal');
            $table->string('shipping_cost');
            $table->string('shipping_method');
            $table->string('receipt_number')->nullable();
            $table->string('total_weight');
            $table->timestamps();
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
};
