<?php
namespace System\Web\Mvcm;

class HttpNotFoundResult extends ActionResult
{
    protected $StatusDescription;
    
    public function __construct($StatusDescription) 
    {
        $this->StatusDescription = $StatusDescription;
    }
    
    public function Execute() 
    {
        echo 'HTTP ERROR - 404.0 - '.$this->StatusDescription;
    }
}