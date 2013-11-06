<?php
namespace System\IO;

class FileInfo
{
    protected $Path;
    public $Type;
    public $Extension;
    public $DateCreated;
    public $DateModifed;
    public $DateAccessed;
    public $Size;
    public $Directory;
    public $Name;


    public function __construct($Path) 
    {
        $this->Path = $Path;
        $this->ReadInfo();
    }

    public function IsExist()
    {
        return file_exists($this->Path);
    }

    public function WriteInfo()
    {
        try
        {
            if (!$this->IsExist())
            {
                fopen(dirname($this->Path).'/'.$this->Name.'.'.$this->Extension, 'w');                
            }
            else
            {
                rename($this->Path, dirname($this->Path).'/'.$this->Name.'.'.$this->Extension);
            }
            touch($this->Path, $this->DateModifed, $this->DateAccessed);
            /*developing...*/            
        } 
        catch (\System\Exception $Ex) 
        {
            throw new \System\Exception('Write info error', $Ex);
        }
    }
    
    public function ReadInfo()
    {
        if (file_exists($this->Path))
        {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);                 
            $this->Type = finfo_file($finfo, $this->Path);
            finfo_close($finfo);    
            $this->Extension = pathinfo($this->Path, PATHINFO_EXTENSION);
            $this->DateCreated  = filectime($this->Path);
            $this->DateModifed = filemtime($this->Path);
            $this->DateAccessed = fileatime($this->Path);
            $this->Size = filesize($this->Path);
            $this->Directory = dirname($this->Path);
            $this->Name = pathinfo($this->Path, PATHINFO_FILENAME);
        }
    }
}