<?php
namespace System\Web\Mvcm;

class JsonResult extends ActionResult
{
    protected $Data;

    public function __construct($Data) 
    {
        $this->Data = $Data;
    }

    public function Execute()
    {
        header('Content-type: text/json');
        echo json_encode($this->Data);
    }
}