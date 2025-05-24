<?php

namespace MVCore;

class View
{

    public string $layout;
    public string $content = '';

    public function __construct($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $data = [], $layout = ''): string
    {
        extract($data);
        $view_file = VIEWS . "/{$view}.php";

        if(is_file($view_file)) {
            ob_start();
            require $view_file;
            $this->content = ob_get_clean();
        } else {
            abort("View not found {$view_file}", 500);
        }

        if (false === $layout) {
            return $this->content;
        }

        $layout_file_name = $layout ?: $this->layout;
        $layout_file = VIEWS . "/layouts/{$layout_file_name}.php";

        if(is_file($layout_file)) {
            ob_start();
            require_once $layout_file;

            return ob_get_clean();
        } else {
            abort("Layout not found {$layout_file}", 500);
        }

        return '';
    }

    public function renderPartial($view, $data = [])
    {
        extract($data);
        $view_file = VIEWS . "/{$view}.php";
        if(is_file($view_file)) {
            require $view_file;
        } else {
            echo "File {$view_file} not found.";
        }
    }

}