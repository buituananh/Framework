<?php
namespace System\Web\Mvcm;

class FileStreamResult extends ActionResult
{
    protected $Stream;
    protected $FileType;
    protected $FileName;
    protected $FileEncode;
    protected $FileExtension;

    public function __construct($Stream, $FileType = NULL, $FileName = NULL, $FileEncode = NULL) 
    {
        throw new \System\Exception('FileStreamResult is developing...');
        try 
        {
            if (!$Stream instanceof \System\IO\Stream)
            {
                throw new \System\Exception('Stream object invalid');
            }            
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Construct file result stream failer', $Ex);
        }
    }

    public function Execute() 
    {
        
    }
}