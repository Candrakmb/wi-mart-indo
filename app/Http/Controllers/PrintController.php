<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\order\Order;
use Barryvdh\DomPDF\Facade\Pdf;


class PrintController extends Controller
{
    public function printPDF($invoice_number)
    {
        // Mendapatkan data order dari database
        $order = Order::where('invoice_number', $invoice_number)->first();

        // Kirim data order ke view
        $data = ['order' => $order];
        
        $pdf = Pdf::loadView('print.invoice', $data);
        // return $pdf->download('invoice.pdf');

        return $pdf->stream();

    }
}
