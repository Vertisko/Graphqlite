<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class NonExistingEntityException extends Exception
{
    /**
     * NonExistingEntityException constructor.
     *
     * @param string $class
     * @param string $identifier
     * @param string $value
     */
    public function __construct(string $class, string $identifier, string $value)
    {
        $message = \sprintf('Entity %s (%s="%s") does not exist.', $class, $identifier, $value);
        parent::__construct($message, Response::HTTP_NOT_FOUND, null);
    }
}
