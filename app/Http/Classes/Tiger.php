<?php
namespace App\Http\Classes;

class Tiger extends Animal
{

    protected $type = 'Tiger';


    protected function setMaximumAllowed()
    {
        $this->maxAllowed = 4;
    }


}