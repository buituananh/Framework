<?php
namespace System;

class Exception extends \Exception
{
    public function __construct($Message, $Previous = NULL, $Code = 0) 
    {
        parent::__construct($Message, $Code, $Previous);
    }
}
