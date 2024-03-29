<?php 

namespace App\Services\Midtrans;
 
use Midtrans\Snap;
 
class CreateSnapTokenService extends Midtrans
{
    protected $order;
 
    public function __construct($order)
    {
        parent::__construct();
 
        $this->order = $order;
    }
 
    public function getSnapToken()
    {
        $totalPay = $this->order->total_pay;
        $adminBank = 5000; 
        $totalMidtrans = $totalPay + $adminBank;

        // Adding $adminBank to the gross_amount parameter
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->invoice_number,
                'gross_amount' => $totalMidtrans,
            ],
            'customer_details' => [
                'first_name' => $this->order->user->name,
                'email' => $this->order->user->email,
                'phone' => $this->order->phone_number,
            ]
        ];

        // Assuming Snap class is available and has the getSnapToken method
        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}