<?php
namespace NoiloanApp\Modules\Test\Test\Test\Models;

class TestModel extends \System\Web\MVCM\Model
{
    public function Show()
    {       
        return \System\ObjectAnalyst::GetClassThis($this);
    }
}
?>
