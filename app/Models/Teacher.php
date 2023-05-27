<?php
//@abdullah zahid joy
namespace App\Models;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Storage;

class Teacher extends BaseModel
{
    //add your model content here
    protected $fillable = [
        'email',
        'name',
        'password',
        "avatar",
        "initial"
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($value)
    {
        if (!empty($value)) {
            return Storage::url($value) ;
        }
        return Storage::url("upload/user/avatar/default.jpg");
    }


}
