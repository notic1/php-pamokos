<?php

class Person 
{
    public function __construct(
        private int $age,
        public string $name,
        protected string $last_name
    )
    {
    }

    protected function setAge(int $age)
    {
        $this->age = $age;
    }

    public function getAge()
    {
        return $this->age;
    }
}