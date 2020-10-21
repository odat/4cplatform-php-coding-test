<?php

namespace App\Exceptions;

/**
 * Class ExceptionTypeEnum
 *
 * @package App\Exceptions
 */
class ExceptionTypeEnum
{
    /**
     * @var string
     */
    public const ACCESS_DENIED = 'ACCESS_DENIED';

    /**
     * @var string
     */
    public const INTERNAL_ERROR = 'INTERNAL_ERROR';

    /**
     * @var string
     */
    public const METHOD_NOT_ALLOWED = 'METHOD_NOT_ALLOWED';

    /**
     * @var string
     */
    public const NOT_FOUND = 'NOT_FOUND';

    /**
     * @var string
     */
    public const VALIDATION_FAILED = 'VALIDATION_FAILED';
}
