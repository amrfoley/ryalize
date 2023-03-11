<?php

namespace App\Action\Web;

use Slim\Views\PhpRenderer;

abstract class BaseAction
{
    protected $renderer;

    public function __construct()
    {
        $this->renderer = new PhpRenderer(__DIR__ . '/../../../public/views');
    }
}
