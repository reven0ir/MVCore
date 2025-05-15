<?php

namespace MVCore;

abstract class Controller
{
    public function render($view, $data = [], $layout = ''): string
    {
        return app()->view->render($view, $data, $layout);
    }
}