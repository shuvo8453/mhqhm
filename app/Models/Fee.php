<?php
//@abdullah zahid joy
namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Storage;

class Fee extends BaseModel
{
    
    //add your model content here
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function feeType(){
        return $this->belongsTo(FeeType::class);
    }
}
