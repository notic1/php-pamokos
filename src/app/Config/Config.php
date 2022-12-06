<?php

namespace App\Config;

class Config
{
    public array $config = [];

    public function __construct(
        array $env
    ) {
        $this->config = [
            'db' => [
                'driver'    => $env['DB_DRIVER'],
                'host'      => $env['DB_HOST'],
                'database'  => $env['DB_DATABASE'],
                'user'      => $env['DB_USER'],
                'password'  => $env['DB_PASSWORD'],
            ]
        ];
    }

    public function __get($name)
    {
        return $this->config[$name] ?? null;
    }
}
