<?php

namespace App\Dashboard\Collection;

use App\Log\Entity\AuthenticationUserLog;

class AuthAttemptsCollection extends \ArrayObject implements \Countable
{
    public function __construct($input = array(), int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        foreach ($input as $key => $value) {
            $this->offsetSet($key, $value);
        }

        parent::__construct($input, $flags, $iterator_class);
    }

    public function offsetSet($offset, $value)
    {
        if (!$value instanceof AuthenticationUserLog) {
            throw new \InvalidArgumentException(
                __CLASS__ . ' can only contain ' . AuthenticationUserLog::class . ' instances'
            );
        }

        parent::offsetSet($offset, $value);
    }

    public function count()
    {
        return count($this->authAttemptsLog);
    }
}
