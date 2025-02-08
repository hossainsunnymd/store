<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = ['description','rating','product_id','customer_profile_id'];

    public function customerProfile(){
        return $this->belongsTo(CustomerProfile::class);
    }

}
