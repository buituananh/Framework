<?php
namespace System\Web\Mvcm;

class ContentResult extends ActionResult
{
    protected $Content;
    protected $ContentType;
    protected $ContentEncoding;
    
    public function __construct($Content, $ContentType, $ContentEncoding) 
    {
        if(!is_string($Content))
        {
            throw new \System\Exception('Parameter $Content must string type');
        }
        $this->Content = $Content;
        $this->ContentType = $ContentType;
        $this->ContentEncoding = $ContentEncoding;
    }

    public function Execute() 
    {
        header("Content-Type: $this->ContentType");        
        echo $this->Content;        
    }
}