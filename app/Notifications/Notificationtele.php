<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\setting\Bank;
use App\Models\order\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class Notificationtele extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }


    public function toTelegram($notifiable)
    {
        $request = request()->all();
        try {
            $invoice = $request['invoice'];
            $order = Order::where('invoice_number', $invoice)->first();
            $tipe = $request['tipe'];

            if ($tipe == '0') {
                $total = $request['total'];
                $idBank = $request['idBank'];
                $bank = Bank::where('id', $idBank)->first();
                $totalRupiah = "Rp " . number_format($total, 0, ',', '.');
                // Membuat content point-point
                $content = "Ada Invoice baru:\n";
                $content .= "Invoice: #" . $invoice . "\n";
                $content .= "Nama Pemesan: " . $order->recipient_name. "\n";
                $content .= "No TLP: " . $order->phone_number. "\n";
                $content .= "Total Pembayaran: " . $totalRupiah . "\n";
                $content .= "Mohon cek bank tujuan berikut: \n";
                $content .= "Bank: " . $bank->nama_bank . "\n";
                $content .= "Atas nama: " . $bank->atas_nama."\n";
                $content .= "Konfirmasi pada web admin";
                
            } else if ($tipe == '1') {
                $orderCreate= Carbon::parse($order->created_at)->format('d F Y H:i:s');
                $totalRupiah = "Rp " . number_format($order->total_pay, 0, ',', '.');
                $content = "Ada order baru masuk $orderCreate:\n";
                $content .= "Invoice: #" . $invoice . "\n";
                $content .= "Nama Pemesan: " . $order->recipient_name. "\n";
                $content .= "Total Pembayaran: " . $totalRupiah . "\n";
                $content .= "Metode Pembayaran: Midtrans \n";
                $content .= "kurir : ". $order->courier. "\n";
                $content .= "Pengiriman : ". $order->shipping_method. "\n";
                $content .= "segera proses untuk kirim ";
            }

            return TelegramMessage::create()
                    ->to(1104082522)
                    ->content($content);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
