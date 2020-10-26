<?php

namespace Fcp\AnimalBreedsSearch;

use Illuminate\Support\Facades\Facade;

class AnimalBreedsSearchFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AnimalBreedsSearch';
    }
}
