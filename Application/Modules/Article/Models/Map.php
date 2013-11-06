<?php
namespace Application\Modules\Article\Models;

class Map extends \System\Web\Mvcm\Model
{
    protected $AppConnectionUse = array('Default');
    protected $ArticleTable = 'app_articles';
    protected $ArticleTypeTable = 'app_articles_types';
    
    public function GetMap()
    {
        try 
        {
            $Query = "SELECT $this->ArticleTable.Name as ArticleName, $this->ArticleTypeTable.* "
                    ."FROM $this->ArticleTypeTable INNER JOIN $this->ArticleTable "
                    ."ON $this->ArticleTypeTable.LastArticleId = $this->ArticleTable.Id"; 
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