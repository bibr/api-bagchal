<?php

namespace App\Http\Classes;


class Position
{

    private $xCoordinate;
    private $yCoordinate;
    private $animal;

    function __construct($coordinate)
    {
        $this->updatePosition($coordinate);
        return $this;
    }

    private function updatePosition($coordinate)
    {
        list($x, $y) = explode(',', trim($coordinate));
        $this->xCoordinate = $x;
        $this->yCoordinate = $y;
    }

    public function getCoordinates()
    {
        return $this->xCoordinate.','.$this->yCoordinate;
    }

    public function getXCoordinate()
    {
        return $this->xCoordinate;
    }

    public function getYCoordinate()
    {
        return $this->yCoordinate;
    }

    public function setAnimal(Animal $animal)
    {
        $this->animal = $animal;
        return $this;
    }

    public function getAnimal()
    {
        return $this->animal;
    }
}