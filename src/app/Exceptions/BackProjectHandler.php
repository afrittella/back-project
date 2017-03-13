<?php
namespace Afrittella\BackProject\Exceptions;

use Afrittella\BackProject\Exceptions\NotFoundException;
use Afrittella\BackProject\Exceptions\NotSavedException;
use Afrittella\BackProject\Exceptions\NotDeletedException;

class BackProjectHandler
{
    public static function getResponse($exception)
    {
        switch ($exception) {
            case ($exception instanceof NotFoundException):
                return response()->view('errors.404', ['exception' => $exception], 404);
                break;

            case ($exception instanceof NotSavedException):
                return response()->view('errors.500', ['exception' => $exception], 500);
                break;

            case ($exception instanceof NotDeletedException):
                return response()->view('errors.500', ['exception' => $exception], 500);
                break;
        }

        return false;
    }
}