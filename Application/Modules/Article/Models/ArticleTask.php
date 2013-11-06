<?php
namespace Application\Modules\Article\Models;

class ArticleTask extends \System\Web\Mvcm\Model
{
    protected $AppConnectionUse = array('Default');
    protected $ArticleTable = 'app_articles';
    protected $ArticleTypeTable = 'app_articles_types';

    public function GetExcellentArticle()
    {
        $Query = "SELECT Id, Name, Contents FROM $this->ArticleTable ORDER BY Id DESC LIMIT 10";
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

    public function GetCoolArticle()
    {
        try 
        {            
            $Types = $this->GetArticleType();
            foreach ($Types as $Type) 
            {
                $Result[$Type['Name']] = $this->GetCoolArticleByType($Type['Id']);
            }
            return $Result;
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Get article cool error', $Ex);
        }
    }
    
    public function GetSupportArticle()
    {
        try 
        {            
            $Result['Question'] = $this->GetCoolArticleByType(9, 5);
            $Result['Manual'] = $this->GetCoolArticleByType(10, 5);
            $Result['FindBugs'] = $this->GetCoolArticleByType(11, 5);
            $Result['Feedback'] = $this->GetCoolArticleByType(12, 5);
            return $Result;
        }
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Get article cool error', $Ex);
        }                
    }
    
    protected function GetCoolArticleByType($TypeId, $Limit = 4)
    {
        $Query = "SELECT Id, Name, Contents FROM $this->ArticleTable WHERE TypeId = $TypeId ORDER BY Id DESC LIMIT $Limit";
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
    
    protected function GetArticleType()
    {
        $Query = "SELECT Id, Name FROM $this->ArticleTypeTable";
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