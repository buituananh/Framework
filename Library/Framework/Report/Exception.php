<?php
namespace System\Report;

class Exception
{
    protected $Exception = NULL;
    
    public function __construct($Exception = NULL) 
    {
        if (empty($Exception)) 
        {
            return;
        }
        $this->Exception = $Exception;
        include_once __DIR__.'/GI/Exception.phtml';
    }
    
    protected function GetTrace($Trace)
    {    
        $Ex = $this->Exception;
        $Row = 
        '<tr>'
            .'<th>Code</th>' 
            .'<th>Line</th>' 
            .'<th>File</th>' 
            .'<th>Message</th>'                 
        .'</tr>';
        while (!empty($Ex)) 
        {
            $Row = $Row
            .'<tr>'
                .'<td>'.$Ex->getCode().'</td>'
                .'<td>'.$Ex->getLine().'</td>'                                    
                .'<td>'.$Ex->getFile().'</td>'                
                .'<td>'.$Ex->getMessage().'</td>'
            .'</tr>';            
            $Ex = $Ex->getPrevious();
        }                
        return $Row;
    }
}