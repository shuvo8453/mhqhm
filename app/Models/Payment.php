<?php
//@abdullah zahid joy
namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Storage;

class Payment extends BaseModel
{
    //add your model content here


    public function details(){
        return $this->hasMany(PaymentDetails::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
