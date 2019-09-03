<?php namespace Agegg\VopClient\Facades;

use Illuminate\Support\Facades\Facade;

class VopClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'vopclient';
    }
}
