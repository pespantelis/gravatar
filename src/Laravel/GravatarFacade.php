<?php

namespace Peslis\Gravatar\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Peslis\Gravatar\Factory
 */
class GravatarFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gravatar';
    }
}
