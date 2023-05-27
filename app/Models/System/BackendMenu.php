<?php
//@abdullah zahid joy
namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class BackendMenu extends Model
{
    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    public function subMenu(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BackendMenu::class,'parent_id','id');
    }
}
