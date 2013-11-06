<?php
namespace System\Web;

class HttpRequest
{
    protected $Uri;
    protected $Method;
    protected $QueryArr = array();
    protected $PostArr = array();
    protected $CookieArr = array();

    public function __construct($Uri, $Method = 'GET')
    {
        $this->Uri = $Uri;
        $this->Method = $Method;
    }
    
    public function AddQuery($QuerryArr)
    {
        $this->QueryArr = array_merge($this->QueryArr, $QuerryArr);
    }
    
    public function AddPost($PostArr)
    {
        $this->PostArr = array_merge($this->PostArr, $PostArr);
    }
    
    public function AddCookie($CookieArr)
    {
        $this->CookieArr = array_merge($this->CookieArr, $CookieArr);
    }
    
    public function AddFile($FilePath)
    {
        throw new \System\Exception('This method developing...');
    }
    
    public function GetRespond()
    {
        $ch = curl_init();
        switch (strtoupper($this->Method))
        {
            case 'POST':
                curl_setopt ($ch, CURLOPT_POST, 1);
                $post = http_build_query($this->PostArr);                
                curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
                break;
            case 'GET':
                curl_setopt ($ch, CURLOPT_HTTPGET, 1);
                break;
            default:
                return FALSE;
        }        
        curl_setopt($ch, CURLOPT_URL, $this->Uri);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));        
        $Data = curl_exec($ch);          
        curl_close($ch);       
        return new HttpRespond($Data);
    }
}
