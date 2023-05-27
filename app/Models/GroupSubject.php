<?php
//@abdullah zahid joy
namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Storage;

class GroupSubject extends BaseModel
{
    
//add your model content here

    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
