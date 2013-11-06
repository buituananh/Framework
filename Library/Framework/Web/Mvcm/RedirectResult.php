<?php
namespace System\Web\Mvcm;

class RedirectResult extends ActionResult
{
    protected $Uri;

    public function __construct($Uri) 
    {
        $this->Uri = $Uri;
    }

    public function Execute() 
    {
        header('Location: '.$this->Uri);
        exit();
    }
}