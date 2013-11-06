<?php
namespace System\Web\Mvcm;

class View extends \System\Object
{
    protected $Src = '';
    protected $AllowSet = array('Module', 'Data', 'ViewBag');
    protected $Icon = '';    
    protected $Title = '';
    protected $CharSet = 'UTF-8';
    protected $Module = NULL;
    protected $Data;
    protected $ViewBag;
    protected $JQueryEnable = FALSE;

    public function __construct() 
    {
        /*Default some properties*/
        if (empty($this->Title)) 
        {
            $this->Title = $this->GetType();
        }
        if (empty($this->Icon)) 
        {
            $this->Icon = \System\Environment::GetSourcesPath().'/Icon/Default/Cloud002.png';                
        }
    }

    protected function RenderTitle()
    {
        echo '<title>'.$this->Title.'</title>';
    }
    /**
     * Render icon for view
     * @param String $Path Path to file image
     */
    protected function RenderIcon($Path)
    {        
        if (!file_exists(\System\Environment::GetRootPath().$Path)) 
        {
            throw new \Exception('Render icon fail: '.\System\Environment::GetRootPath().$Path);         
        }
        echo '<link href="'.$Path.'" rel="shortcut icon" >';         
    }
    /**
     * Render javascript
     * @param String $Path Path to javascript file
     */
    protected function RenderJs($Path)
    { 
        $Path = $Path.'.js';
        if (!file_exists(\System\Environment::GetRootPath().$Path)) 
        {
            throw new \Exception('Render JavaScript fail: '.\System\Environment::GetRootPath().$Path);        
        }
        echo '<script src="'.$Path.'"></script>';               
    }
    /**
     * Render css 
     * @param String $Path Path to css file
     */
    public function RenderCss($Path)
    {
        $Path = $Path.'.css';
        if (!file_exists(\System\Environment::GetRootPath().$Path)) 
        {
            throw new \Exception('Render  Cascading Style Sheets fail: '.\System\Environment::GetRootPath().$Path);
        }
        echo '<link rel="stylesheet" type="text/css" href="'.$Path.'" >';
    } 
    /**
     * Get pointer to model (inside or outside module)
     * @param String $Path Path to model by two format: <br>
     *  Invoke model inside module: ~/Module/.../Model <br>
     *  Invoke model outside module: /Module/.../Model <br>
     * @return Pointer Pointer to model
     */
    protected function GetModel($Path)
    {
        /*Use method of module to run*/
        try
        {
            return $this->Module->GetModel($Path);            
        }
        catch (\Exception $Ex)
        {
            throw new \Exception('View get model fail: Path = '.$Path, 0, $Ex);
        }
    }
    /**
     * Run view
     * @return Mixed Result from master render
     */
    public function Run()
    { 
        /**/
        echo '<!DOCTYPE HTML>';
        echo '<html>';
        echo '<head>';
        echo '<meta content="text/html; charset='.$this->CharSet.'" http-equiv="content-type">';
        $this->RenderIcon($this->Icon);
        $this->RenderTitle($this->Title);
        $this->RenderCss(\System\Environment::GetSourcesPath().'/Css/Standard');
        if($this->JQueryEnable)
        {
            $this->RenderJs(\System\Environment::GetSourcesPath().'/JQuery/2-0-0-min');
        }
        echo '</head>';
        /*Run master render*/
        echo '<body>';
        $this->RenderCenter(); 
        echo '</body>';
        echo '</html>';
    }
    /**
     * Render phtml file
     * @param String $Path Path to phtml file
     * 
     */
    protected function RenderPhtml($Path)
    {    
        /*Check exist file need render*/
        if (!file_exists($Path.'.phtml')) 
        {
            throw new \Exception('Render Phtml fail: '.$Path);
        }
        /*Include as render*/
//        include_once $Path.'.phtml';
        $Content = file_get_contents($Path.'.phtml');
        var_dump(\System\Web\HtmlTag::FindTag($Content, '/<phtml:Holder\s.*\s\/>/'));
        print_r($Content);
        /*Render success*/
        return TRUE;   
    }      
    
    final protected function RenderCenter()
    {
//        $this->RenderPhtml($this->GetDirPath().'/View');
        $this->OnPreRender();
        echo $this->ExecuteMasterPage($this->GetDirPath().'/View.phtml');
    }
    
    public static function FindTag($Content, $TagName)
    {
        $PregOpen = '/<'.$TagName.'\s.*>/';
        $TagClose = '</'.$TagName.'>'; 
        $FoundOpen = array();
        preg_match_all($PregOpen, $Content, $FoundOpen);
        $Tags = array();   
        foreach ($FoundOpen[0] as $Open) 
        {
            $TagName = substr($Open, 1, strpos($Open, ' ') - 1);
            $Tag = array();
            $Tag['Name'] = $TagName;        
            $Tag['Open'] = strpos($Content, $Open);
            $Tag['Len'] = strlen($Open); 
            $Tag['Tag'] = $Open;
            $Open = substr($Open, strpos($Open, ' ') + 1);
            $Open = substr($Open, 0, strlen($Open) - 1);        
            $ParseProperty = str_getcsv($Open, ' ');
            $Property = array();        
            foreach ($ParseProperty as $Elements) 
            {
                $Element = str_getcsv($Elements, '='); 
                $Property[$Element[0]] = $Element[1];
            }       
            $Tag['Prop'] = $Property;
            /*Find close tag to get content*/        
            $Tag['Close'] = strpos($Content, $TagClose, $Tag['Open']);
            $Tag['Content'] = substr($Content, $Tag['Open'] + $Tag['Len'], $Tag['Close'] - $Tag['Open'] - $Tag['Len']);
            array_push($Tags, $Tag);
        }
        return $Tags;
    }
    public function ExecuteMasterPage($VFilePath)
    {
        ob_start();
        include $VFilePath;
        $VContent = ob_get_contents();
        ob_clean();        
        /*Find master page*/
        $PagePropMatch = array();
        preg_match('/<%.*%>/', $VContent, $PagePropMatch);
        if(empty($PagePropMatch)) 
        {
            echo $VContent;
            return;
        }
        $PagePropMatch = $PagePropMatch[0];
        $PagePropMatch = substr($PagePropMatch, strpos($PagePropMatch, ' ') + 1);
        $PagePropMatch = substr($PagePropMatch, 0, strrpos($PagePropMatch, ' '));
        $PagePropParse = str_getcsv($PagePropMatch, ' ');
        $Props = array();
        foreach ($PagePropParse as $PropPair) 
        {
            $Prop = str_getcsv($PropPair, '=');
            $Props[$Prop[0]] = $Prop[1];
        }
        $MpFilePath = $this->Module->GetMgrModuleLeader()->GetDirPath();
        foreach ($Props as $Key => $Value)
        {
            if($Key == 'Module')
            {
                $MpFilePath = $MpFilePath.str_replace('/', '/Modules/', $Value);
            }
            if($Key == 'Controller')
            {
                $MpFilePath = $MpFilePath.'/Views/'.$Value;
            }      
            if($Key == 'View')
            {
                $MpFilePath = $MpFilePath.'/'.$Value.'/View.phtml';
            }               
        }
        ob_start();
        include $MpFilePath;
        $MpContent = ob_get_contents();
        ob_clean();         
        $MpTags = self::FindTag($MpContent, 'asp:Holder');
        $VTags = self::FindTag($VContent, 'asp:Holder');    
        foreach ($MpTags as $MpTag)
        {       
            foreach ($VTags as $VTag)
            {            
                if($MpTag['Prop']['id'] == $VTag['Prop']['id'])
                {
                    $MpContent = str_replace($MpTag['Tag'], $VTag['Content'], $MpContent);
                    break;
                }
            }          
        }
        return $MpContent;
    }   
    
    protected function OnPreRender()
    {
        
    }
}