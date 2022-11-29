<?php 

namespace App;

class SuperCoffeMaker extends BaseCoffeMaker
{
    use MakesMokka;
    public int $milk = 10;

    public function makeLatte()
    {
        echo 'Making latte';
    }

    public function decreaseMilkLevel()
    {
        $this->milk--;
    }
}