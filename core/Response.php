<?php

namespace MVCore;

class Response
{
    public function setResponseCode(int $code): void
    {
        http_response_code($code);
    }

    //TODO: add response code 302
    public function redirect(string $url = '', int $code = 302): never
    {
        if ($url) {
            $redirect_url = $url;
        } else {
            $redirect_url = $_SERVER['HTTP_REFERER'] ?? base_url();
        }

        header("Location: {$redirect_url}", true, $code);
        die;
    }
}
