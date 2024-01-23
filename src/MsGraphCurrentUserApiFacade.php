<?php

namespace Joeystowe\MsGraphApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Joeystowe\MsGraphApi\Skeleton\SkeletonClass
 */
class MsGraphApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ms-graph-current-user-api';
    }
}
