<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'total',
        'vat',
        'payable',
        'cus_details',
        'ship_details',
        'tran_id',
        'delivery_status',
        'payment_status',
        'user_id'
    ];

    public function invoiceProduct()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
