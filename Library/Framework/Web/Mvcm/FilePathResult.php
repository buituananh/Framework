<?php
namespace System\Web\Mvcm;

class FilePathResult extends ActionResult
{
    protected $File;
    protected $FileType;
    protected $FileName;
    protected $FileEncode;    

    public function __construct($FilePath, $FileType = NULL, $FileName = NULL, $FileEncode = NULL) 
    {
        $this->File = new \System\IO\File($FilePath);
        if (!$this->File->IsExist())
        {
            throw new \System\Exception('File not exist');
        }            
        if ($FileType == NULL)
        {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);               
            $this->FileType = finfo_file($finfo, $this->File->GetPath());
            finfo_close($finfo);             
        }
        else
        {
            $this->FileType = $FileType;
        }
        if ($FileName == NULL) 
        {
            $this->FileName = pathinfo($this->File->GetPath(), PATHINFO_BASENAME);
        }
        else
        {
            $this->FileName = $FileName;
        }
        if ($FileEncode == NULL)
        {
            $this->FileEncode = 'binary';
        }
        else
        {
            $this->FileEncode = $FileEncode;
        }          
    }
    
    public function Execute() 
    {
        try
        {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attackment; filename=$this->FileName");
            header("Content-Type: $this->FileType");
            header("Content-Transfer-Encoding: $this->FileEncode");
            header('Content-Length: '.filesize($this->File->GetPath()));
            
            readfile($this->File->GetPath());           
            exit();            
        } 
        catch (\System\Exception $Ex)
        {
            throw new \System\Exception('Download file error', $Ex);
        }
    }
}