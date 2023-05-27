<?php
//@abdullah zahid joy
namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Storage;

class Group extends BaseModel
{
    
//add your model content here

    public function fee(){
        return $this->hasMany(Fee::class);
    }

    public function student(){
        return $this->hasMany(User::class);
    }

    public function subject(){
        return $this->belongsToMany(Subject::class,'group_subjects',"group_id",'subject_id');
    }
}
