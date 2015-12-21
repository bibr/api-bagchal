<?php
namespace App\Http\Classes;

abstract class Animal
{

    protected $state; // sleeping, alive, dead
    protected $type;
    protected $maxAllowed;

    public function __construct()
    {
        $this->state = 'alive';
        $this->setMaximumAllowed();
    }

    abstract protected function setMaximumAllowed();

    public function getState()
    {
        return $this->state;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getMaximumAllowed()
    {
        return $this->maxAllowed;
    }


}
