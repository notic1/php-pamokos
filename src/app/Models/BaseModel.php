<?php 

namespace App\Models;

use App\App;
use App\DB;

abstract class BaseModel
{
    protected DB $pdo;

    public function __construct()
    {
        $this->pdo = App::db();
    }
}