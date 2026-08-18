<?php

namespace App\Traits;

use App\Support\DatabaseExceptionMapper;
use Throwable;

trait HandlesDatabaseExceptions
{
    protected function handleException(Throwable $e, string $fallback = 'An error occurred. Please try again.', bool $withInput = true)
    {
        $message = DatabaseExceptionMapper::toUserMessage($e, $fallback);

        $response = back();

        if ($withInput) {
            $response = $response->withInput();
        }

        return $response->with('error', $message);
    }
}
