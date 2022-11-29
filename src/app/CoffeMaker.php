<?php 

namespace App;

interface CoffeMaker
{
    public function clean(): string;
    public function makeCoffe(): string;
}