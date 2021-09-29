<?php

namespace App\Traits;

use Exception;

trait ThrowValidationErrorTrait
{
    /**
     * @param array $messages
     * @param int $code
     * @throws Exception
     */
    public function throwValidationError($messages = [], $code = 422)
    {
        $error = new Exception($messages, $code);

        throw $error;
    }
}
