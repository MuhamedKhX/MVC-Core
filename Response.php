<?php


namespace muhamex\phpmvc;


class Response
{
    public function changeStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }
}