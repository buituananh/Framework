<?php
namespace Application\Modules\User\Models;

class Info extends \System\Web\Mvcm\Model
{
    public function GetAvatarLinkByUserName($UserName)
    {
        $Path = '/Sources/User/Img/Avatar/'.$UserName.'.jpg';        
        if (!file_exists($_SERVER['DOCUMENT_ROOT'].$Path)) 
        {
            $Path = '/Sources/User/Img/Default/User.png';
        }
        return $Path;        
    }
}