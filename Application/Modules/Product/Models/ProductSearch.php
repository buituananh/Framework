<?php
namespace Application\Modules\Product\Models;

class ProductSearch extends \System\Web\Mvcm\Model
{
    protected $AppConnectionUse = array('Default');
    protected $ProductTableName = 'app_products';
    
    public function Pagging($Page, $RowPerPage)
    {
        try 
        {
            $Offset = ($Page - 1)*$RowPerPage;
            $Query = "SELECT Id, Name FROM $this->ProductTableName ORDER BY Id DESC LIMIT $RowPerPage OFFSET $Offset";
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
            throw new \System\Exception('Search error', $Ex);
        }            
    }
}