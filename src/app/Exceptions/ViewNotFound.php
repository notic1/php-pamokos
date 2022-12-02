<?php

namespace App\Exceptions;

class ViewNotFound extends \Exception
{
    protected $message = 'View not found';
    protected $code = 404;
}