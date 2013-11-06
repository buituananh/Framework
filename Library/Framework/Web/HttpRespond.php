<?php
namespace System\Web;

class HttpRespond
{
    protected $Data;
    
    public function __construct($Data)
    {
        $this->Data = $Data;
    }
    
    public function GetData()
    {
        return $this->Data;
    }
}
