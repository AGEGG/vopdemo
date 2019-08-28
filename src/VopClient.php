<?php
namespace Agegg\Vop;

//use Illuminate\Support\Facades\Facade;

class VopClient
{
    public static function connection()
    {
        return new Vop(config('services.vop.appKey'), config('services.vop.appSecret'));
    }
}
