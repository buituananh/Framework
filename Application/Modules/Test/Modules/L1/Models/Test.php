<?php
namespace Application\Modules\Test\L1\Models;

class Test extends \System\Web\Mvcm\Model
{
    public function GetSmt()
    {
        return $this->GetType();
    }
}
