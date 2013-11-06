<?php
namespace System\Web\Mvcm;

class Model extends \System\Object
{
    protected $AllowSet = array('Module');
    protected $AllowGet = array();
    protected $Module; 
    protected $AppConnectionUse = array();
    protected $Connections = array();
    
    final public function ImportAppConnection($Name)
    {
        try
        {
            $Connection = $this->Module->Application->Get('Config')->Connections->$Name;
            $this->Connections[$Name] = mysqli_connect($Connection->Server, $Connection->User, $Connection->Password, $Connection->Database);                    
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Import application connection error, name = '.$Name, $Ex);
        }
    }
    
    final public function OnPreCompleteConstruct()
    {
        try
        {
            foreach ($this->AppConnectionUse as $ConnectionName) 
            {
                $this->ImportAppConnection($ConnectionName);
            }            
        }
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('OnPreCompleteConstruct error', $Ex);
        }
    }
    
    public function OnCompleteConstruct()
    {
        
    }
    
    final public function __destruct() 
    {
        foreach ($this->Connections as $Connection)
        {
            $Connection->Close();
        }
    }
}