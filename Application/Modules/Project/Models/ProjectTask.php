<?php
namespace Application\Modules\Project\Models;

class ProjectTask extends \System\Web\Mvcm\Model
{
    protected $AppConnectionUse = array('Default');
    protected $ProjectTable = 'app_projects';
    protected $ProjectStateTable = 'app_projects_state';

    public function GetExcellent()
    {
        $Query = "SELECT Id, Name FROM $this->ProjectTable ORDER BY Id DESC LIMIT 5";
        $SrcResult = $this->Connections['Default']->query($Query);
        $Result = array();
        if($SrcResult)
        {
            while ($Row = $SrcResult->fetch_assoc())
            {
                array_push($Result, $Row);
            }
        }   
        return $Result;        
    }

    public function GetBest()
    {
        try 
        {            
            $States = $this->GetProjectState();
            foreach ($States as $State) 
            {
                $Result[$State['Name']] = $this->GetBestByState($State['Id']);
            }
            return $Result;
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Get article cool error', $Ex);
        }
    }
    
    protected function GetBestByState($StateId)
    {
        $Query = "SELECT Id, Name, Summary FROM $this->ProjectTable WHERE StateId = $StateId ORDER BY Id DESC LIMIT 10";
        $SrcResult = $this->Connections['Default']->query($Query);
        $Result = array();
        if($SrcResult)
        {
            while ($Row = $SrcResult->fetch_assoc())
            {
                array_push($Result, $Row);
            }
        }   
        return $Result;
    }
    
    protected function GetProjectState()
    {
        $Query = "SELECT Id, Name FROM $this->ProjectStateTable";
        $SrcResult = $this->Connections['Default']->query($Query);
        $Result = array();
        if($SrcResult)
        {
            while ($Row = $SrcResult->fetch_assoc())
            {
                array_push($Result, $Row);
            }
        }   
        return $Result;        
    }
}