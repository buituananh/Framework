<?php
namespace Application\Modules\Article\Models;

class ArticleSearch extends \System\Web\Mvcm\Model
{
    protected $ArticleTable = 'app_articles';
    protected $AppConnectionUse = array('Default');

    public function SearchByAuthor($AuthorId, $Page, $RowPerPage)
    {
        try 
        {
            $Offset = ($Page - 1)*$RowPerPage;
            $Query = "SELECT Id, Name FROM $this->ArticleTable WHERE UserId='$AuthorId' ORDER BY Id DESC LIMIT $RowPerPage OFFSET $Offset";
            $SrcResult = $this->Connections['Default']->query($Query);
            $ArrResult = array();
            while ($Row = $SrcResult->fetch_array())
            {
                array_push($ArrResult, $Row);
            }                
            return $ArrResult;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Search error', $Ex);
        }       
    }
    
    public function SearchContentByAuthor($AuthorId, $Page, $RowPerPage)
    {
        try 
        {
            $Offset = ($Page - 1)*$RowPerPage;
            $Query = "SELECT Id, Name, Contents FROM $this->ArticleTable WHERE UserId='$AuthorId' ORDER BY Id DESC LIMIT $RowPerPage OFFSET $Offset";
            $SrcResult = $this->Connections['Default']->query($Query);            
            if(!is_object($SrcResult))
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
            throw new \System\Exception('Search error', $Ex);
        }       
    }    
}