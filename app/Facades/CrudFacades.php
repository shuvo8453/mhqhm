<?php
//@abdullah zahid joy
namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class CrudFacades extends Facade{

    protected static function getFacadeAccessor(): string
    {
       return 'crud';
    }

}