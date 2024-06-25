<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaymentsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $payments = Payment::with('user', 'application')->get();

        return $payments->map(function ($payment) {
            return [
                'Student Name' => $payment->user->full_name ?? 'N/A',
                'Application No' => $payment->user->student->application_unique_number ?? 'N/A',
                'Transaction Id' => $payment->transaction_id ?? 'N/A',
                'Payment Type' => $payment->payment_method ?? 'N/A',
                'Invoice No' => $payment->application->invoice_number ?? 'N/A',
                'Status' => $payment->payment_status == 'successful' ? 'Successful' : 'Error',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Student Name',
            'Application No',
            'Transaction Id',
            'Payment Type',
            'Invoice No',
            'Status',
        ];
    }
}
