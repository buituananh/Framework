<?php
namespace System\Web\Routing;

class RequestContext
{    
    public $HttpContextBase;
    public $Router;
    
    public function __construct($HttpContextBase, $Router)
    {
        $this->HttpContextBase = $HttpContextBase;
        $this->Router = $Router;
    }
}