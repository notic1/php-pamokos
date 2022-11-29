<?php

namespace App;

trait MakesMokka
{
    public function makeMokka()
    {
        echo 'Making mokka';

        $this->decreaseMilkLevel();
    }
}