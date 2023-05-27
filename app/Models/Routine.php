<?php
//@abdullah zahid joy
namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Storage;

class Routine extends BaseModel
{
    //add your model content here
    public function details(){
        return $this->hasMany(RoutineDetails::class);
    }

}
