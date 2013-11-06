<?php
namespace System\Web\Mvcm;

class ViewResult extends ActionResult
{
    protected $Module = NULL;
    protected $ControllerName = '';
    protected $ViewName = '';
    protected $Data;
    protected $ViewBag;

    public function __construct($Module, $ControlelrName, $ViewName, $Data, $ViewBag) 
    {
        if(!$Module instanceof \System\Web\Mvcm\Module)
        {
            throw new \System\Exception('Parameter $Module must module type');
        } 
        if(!is_string($ControlelrName) || empty($ControlelrName))
        {
            throw new \System\Exception('Parameter $ControlelrName must string type and not empty');
        }
        if(!is_string($ViewName) || empty($ViewName))
        {
            throw new \System\Exception('Parameter $ViewName must string type and not empty');
        }        
        $this->Module = $Module;
        $this->ControllerName = $ControlelrName;
        $this->ViewName = $ViewName;
        $this->Data = $Data;        
        $this->ViewBag = $ViewBag;
    }
    
    public function Execute() 
    {
        try
        {
            /*Use ResultAction + MgrView to create view*/
            $this->Module->CreateViewMgr();
            $View = $this->Module->GetView($this->ControllerName, $this->ViewName); 
            $View->Set('Data', $this->Data);
            $View->Set('ViewBag', $this->ViewBag);
            /*Run View*/
            $View->Run();             
        }
        catch (\System\Exception $Ex) 
        {            
            throw new \System\Exception('Error during excute view result', $Ex);
        }
    }
}