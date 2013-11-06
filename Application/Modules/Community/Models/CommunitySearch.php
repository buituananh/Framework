<?php
namespace Application\Modules\Community\Models;

class CommunitySearch extends \System\Web\Mvcm\Model
{
    protected $AppConnectionUse = array('Default');
    protected $CommunityTable = 'app_communities';
    protected $ArticleTable = 'app_articles';
    protected $ArticleTypeTable = 'app_articles_types';


    public function GetAll()
    {
        try
        {
            $Query = "SELECT $this->CommunityTable.Id, $this->CommunityTable.Name, $this->CommunityTable.NumberMember, $this->ArticleTable.Contents as LastActive, $this->ArticleTypeTable.Name as TypeId "
                    ."FROM $this->CommunityTable "
                    ."INNER JOIN $this->ArticleTable ON $this->CommunityTable.LastActive = $this->ArticleTable.Id "
                    ."INNER JOIN $this->ArticleTypeTable ON $this->CommunityTable.TypeId = $this->ArticleTypeTable.Id";
            $SrcResult = $this->Connections['Default']->query($Query);
            if(!$SrcResult)
            {
                return FALSE;
            }
            $Result = array();
            while ($Row = $SrcResult->fetch_assoc())
            {
                array_push($Result, $Row);
            }
            return $Result;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Get all community error', $Ex);
        }
    }
}