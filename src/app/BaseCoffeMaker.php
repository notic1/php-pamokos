<?php

namespace App;

require_once('CoffeMaker.php');

abstract class BaseCoffeMaker 
{
    public function clean(): string
    {
        return 'Cleaning';
    }

    public function makeCoffe(): string
    {
        return 'Making coffe';
    }
}
