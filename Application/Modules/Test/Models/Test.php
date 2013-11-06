<?php
namespace Application\Modules\Test\Models;

class Test extends \System\Web\Mvcm\Model
{
    public function GetSmt()
    {
        return $this->GetType();
    }
}
