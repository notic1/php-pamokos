<?php

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Exceptions\ViewNotFound;

class View
{
    public function __construct(
        protected string $view,
        protected array $arguments = []
    ) {
    }

    public function render()
    {
        self::class;
        $viewPath = VIEW_PATH . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new ViewNotFound();
        }
        
        include VIEW_PATH . 'layouts/app.php';

        return ob_get_clean();
    }

    public static function make(string $view, array $arguments)
    {
        return new static($view, $arguments);
    }

    public function __toString()
    {
        return $this->render();
    }

    public function __get($name)
    {
        return $this->arguments[$name] ?? null;
    }
}
