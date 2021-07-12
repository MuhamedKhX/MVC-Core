<?php


class exceptionX extends Exception
{
    protected $message = "You Dont Have Permission";
    protected $code = 403;
}