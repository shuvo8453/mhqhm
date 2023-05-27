<?php
//@abdullah zahid joy
namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Storage;

class RoutineDetails extends BaseModel
{
    //add your model content here
    public function routine(){
        return $this->belongsTo(Routine::class);
    }

}
