<?php
//@abdullah zahid joy
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];


    public function feeType(){
        return $this->belongsTo(FeeType::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

}
