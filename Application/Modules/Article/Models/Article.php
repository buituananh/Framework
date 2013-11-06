<?php
namespace Application\Modules\Article\Models;

class Article extends \System\Web\Mvcm\Model
{
    protected $AppConnectionUse = array('Default');
    protected $ArticleTable = 'app_articles';
    
    public function Select($Id)
    {
        try 
        {
            mysqli_query($this->Connections['Default'], 'SET NAMES utf8');
            $Query = "SELECT * FROM $this->ArticleTable WHERE Id='$Id'";
            $SrcResult = $this->Connections['Default']->query($Query);
            $ArrResult = $SrcResult->fetch_assoc();                   
            return $ArrResult;
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Get article by id error', $Ex);
        }          
    }
    
    public function Insert($Data)
    {
        try 
        {
            $Title = addslashes(trim($Data['Name']));  
            $Contents = addslashes(trim($Data['Contents']));  
            $UserId = $Data['UserId'];
            $Query = "INSERT INTO $this->ArticleTable (Name, Contents, UserId) VALUES ('$Title', '$Contents', '$UserId')";
            $this->Connections['Default']->query($Query);                  
            if($this->Connections['Default']->affected_rows == 1)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }  
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Get article by id error', $Ex);
        }          
    }
    
    public function Delete($Id)
    {
        try 
        {             
            $Query = "DELETE FROM $this->ArticleTable WHERE Id='$Id'";
            $this->Connections['Default']->query($Query);
            if($this->Connections['Default']->affected_rows == 1)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }            
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Delete article by id error', $Ex);
        }          
    }
    
    public function Update($Id, $Data)
    {
        try 
        {   
            $Title = addslashes(trim($Data['Name']));  
            $Contents = addslashes(trim($Data['Contents']));            
            $Query = "UPDATE $this->ArticleTable SET Name='$Title', Contents='$Contents' WHERE Id='$Id'";
            $this->Connections['Default']->query($Query);
            if($this->Connections['Default']->affected_rows == 1)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }            
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Get article by id error', $Ex);
        }            
    }
}