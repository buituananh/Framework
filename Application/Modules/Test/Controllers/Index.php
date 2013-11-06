<?php
namespace Application\Modules\Test\Controllers;

class Index extends \System\Web\Mvcm\Controller
{    
    protected $ActionDef = 'Index';   

    public function Index()
    {                 
        return $this->View();
    }
    public function UploadFile()
    {      
        
        if(isset($_FILES['File']))
        {
            echo 'Yes';
        }
        else
        {
            echo 'No';
        }
        
        return $this->Quit();
    }    
    public function Json_Smt()
    {               
        $Data = array('dddd', 'dddd');
        return $this->Json($Data);
    } 
    
    public function Rdr()
    {                               
        return $this->Redirect('/Test/Index');
    }    
    
    public function DownFile()
    {
        $File = new \System\IO\File(\System\Web\Server::MapPath('/Application/File/ASP.NET.rar'));
        return $this->FileContent($File);
    }
    public function DownFileStream()
    {
        return $this->FileStream(null);
    }

    public function FileInfo()
    {        
        $FileInf = new \System\IO\FileInfo(\System\Web\Server::MapPath('/Application/File/f.zip'));
        if(!$FileInf->IsExist())
        {
            throw new \System\Exception('File not exist');
        }
        echo $FileInf->DateModifed;
        $FileInf->DateModifed = time();
        $FileInf->WriteInfo();
        $FileInf->ReadInfo();
        echo '<br>'.$FileInf->DateModifed;
        echo '<br>'.$FileInf->DateAccessed;
        echo '<br>'.$FileInf->Extension;
        echo '<br>'.$FileInf->Size;
        echo '<br>'.$FileInf->Type;
        return $this->Json(array());
    }
    
    public function CF()
    {
        $File = new \System\IO\File(\System\Web\Server::MapPath('/Application/File/ASP.rar'));
        $File->SetContent('123');
        $File->Write();
        return $this->ResultExit();
    }
    
    public function TryReq()
    {
        $Req = new \System\Web\HttpRequest('http://vozforums.com');
        $Res = $Req->GetRespond();
        echo($Res->GetData());
        return $this->ResultExit();
    }
    
    public function ExecuteFile()
    {               
        if(isset($_GET['f'])) $FileName = $_GET['f'];
        else throw new \System\Exception('File empty');
        $File = new \System\IO\File('E:\Ting\Video\\'.$FileName);
        if(!$File->IsExist()) throw new \System\Exception('File not exist');
        return $this->Excute($File);
    }
    
    public function Range()
    {
        var_dump($_SERVER['HTTP_RANGE ']);
        return $this->Quit();
    }
    
    public function ListFile()
    {
        $ListFile = scandir('E:\Ting\Video');        
        foreach ($ListFile as $value) {
            if($value != '.' && $value != '..') echo '<a href="/Test/Index/ExecuteFile?f='.urlencode($value).'" target="_blank" >'.$value.'</a> <br>';
        }
            
        return $this->Quit();
    }
    
    public function LS()
    {        
        \System\CodeManager::ViewSpace('/');
        return $this->Quit();
    }
    public function TrimFile()
    {        
        \System\CodeManager::StandardizedFile('/');
        return $this->Quit();
    }    
    public function GCFF()
    {
        $c = \System\CodeManager::GetClassFromFile(\System\Web\Server::MapPath('/Library/RecycleBin/SampleLib.php'));        
        var_dump($c);
        return $this->Quit();
    }    
}
