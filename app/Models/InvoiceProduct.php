<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $fillable = ['invoice_id','product_id','qty','sale_price','user_id'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
