<?php
/**
 * Created by PhpStorm.
 * User: Pramod
 * Date: 21/08/2015
 * Time: 10:01 AM
 */

namespace App\Http\Classes;


class Goat extends Animal
{

    protected $type = 'Goat';
    protected $maxAllowed = 4;

    function updateState($state)
    {
        $this->active = $state; // sleeping, alive, dead
    }

    protected function setMaximumAllowed()
    {
        $this->maxAllowed = 20;
    }
}