<?php
namespace Application\Modules\Article\Models;

class TypeRead extends \System\Web\Mvcm\Model
{
    protected $AppConnectionUse = array('Default');
    protected $ArticleTable = 'app_articles';
    protected $ArticleTypeTable = 'app_articles_types';
    
    public function GetByTypeId($Id)
    {
        try 
        {
            $Query = "SELECT * FROM $this->ArticleTable WHERE TypeId = $Id"; 
            $SrcResult = $this->Connections['Default']->query($Query);            
            if(!$SrcResult)
            {
                return FALSE;
            }
            $ArrResult = array();
            while ($Row = $SrcResult->fetch_array())
            {
                array_push($ArrResult, $Row);
            } 
            return $ArrResult;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Get article by id error', $Ex);
        }           
    }
}