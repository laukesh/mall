<?php

namespace App\Support;

use Illuminate\Database\QueryException;
use Throwable;

class DatabaseExceptionMapper
{
    public static function toUserMessage(Throwable $e, ?string $fallback = null): string
    {
        if (! $e instanceof QueryException) {
            return $fallback ?? 'An error occurred. Please try again.';
        }

        $errorCode = $e->errorInfo[1] ?? null;
        $message = $e->getMessage();

        switch ($errorCode) {
            case 1062:
                return self::duplicateEntryMessage($message);
            case 1451:
                return 'Cannot delete or update this record because it is linked to other records.';
            case 1452:
                return 'Invalid reference. The related record does not exist or was removed.';
            case 1048:
                return 'A required field is missing. Please fill in all required fields.';
            case 1364:
                return 'A required field has no default value. Please fill in all required fields.';
            default:
                if (str_contains($message, 'Duplicate entry')) {
                    return self::duplicateEntryMessage($message);
                }

                if (str_contains($message, 'foreign key constraint')) {
                    if (str_contains($message, 'Cannot delete') || str_contains($message, 'Cannot update')) {
                        return 'Cannot delete or update this record because it is linked to other records.';
                    }

                    return 'Invalid reference. The related record does not exist or was removed.';
                }

                return $fallback ?? 'A database error occurred. Please try again.';
        }
    }

    private static function duplicateEntryMessage(string $message): string
    {
        if (preg_match("/Duplicate entry '([^']*)' for key '([^']+)'/", $message, $matches)) {
            $value = $matches[1];
            $field = self::keyToFieldName($matches[2]);

            if ($value !== '') {
                return "The {$field} \"{$value}\" already exists. Please use a different value.";
            }

            return "The {$field} already exists. Please use a different value.";
        }

        return 'This record already exists. Please check for duplicate values.';
    }

    private static function keyToFieldName(string $key): string
    {
        $key = preg_replace('/^[^.]+\\./', '', $key);
        $key = preg_replace('/_(unique|primary)$/', '', $key);

        $parts = explode('_', $key);
        if (count($parts) >= 3) {
            $key = implode('_', array_slice($parts, 1));
        }

        return str_replace('_', ' ', $key);
    }
}
