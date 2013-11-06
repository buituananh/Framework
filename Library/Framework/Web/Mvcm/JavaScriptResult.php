<?php
namespace System\Web\Mvcm;

class JavaScriptResult extends ActionResult
{
    protected $Script;
    
    public function __construct($Script) 
    {
        $this->Script = $Script;
    }
    
    public function Execute() 
    {
        echo $this->Script;
    }
}