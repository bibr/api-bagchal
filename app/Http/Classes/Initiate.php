<?php

namespace app\Http\Classes;

use App\Http\Classes\Position;

class Initiate
{
    private $animalObj = [];
    private $allPosObj = [];
    private $nextMove;
    private $totalSleepingGoat = 20;
    private $totalAliveGoat = 0;
    private $totalDeadGoat = 0;

    public function __construct()
    {

    }

    public function insertAnimal($position, Animal $animal)
    {
        (count($position) > $animal->getMaximumAllowed()) ?
            die('invalid number of animal') :
            false;

        for ($i = 0; $i < count($position); $i++) {
            $this->animalObj[$i] = $animal;
            $tempPosObj = (new Position($position[$i]))->setAnimal($this->animalObj[$i]);

            //Check if Position already have animal
            foreach ($this->allPosObj as $obj) {
                $result = (strpos(serialize($obj->getCoordinates()), serialize($tempPosObj->getCoordinates())) !== false);
                ($result) ? die('two animal in same position') : false;
            }

            $this->allPosObj[] = $tempPosObj;
        }
        $this->updateGoat();
        return $this;
    }

    private function updateGoat()
    {
        foreach ($this->allPosObj as $obj) {
            if ($obj->getAnimal()->getType() == 'Goat') {

                switch ($obj->getAnimal()->getState()) {
                    case 'alive':
                        $this->totalAliveGoat++;
                        break;
                    case 'dead':
                        $this->totalDeatGoat++;
                }
            }
        }
        $this->totalSleepingGoat -= $this->totalAliveGoat + $this->totalDeadGoat;
    }

    public function getAllPosition()
    {
        return $this->allPosObj;
    }

    public function setNextMove($tiger, $goat)
    {
        $this->nextMove = [
            'Tiger' => $tiger,
            'Goat' => $goat,
        ];
        return $this;
    }

    public function getNextMove()
    {
        foreach($this->nextMove as $key=>$val){
            if($val) return $key;
        }
    }

    public function getLayout()
    {
        $return = [];
        foreach ($this->allPosObj as $obj) {
            $return['position'][$obj->getAnimal()->getType()][] = $obj->getCoordinates();
        }
        $return['nextMove'] = $this->nextMove;
        $return ['GoatData'] = [
            'sleeping' => $this->totalSleepingGoat,
            'alive' => $this->totalAliveGoat,
            'dead' => $this->totalDeadGoat,
        ];
        return $return;
    }

    public function getTotalSleepingGoat()
    {
        return $this->totalSleepingGoat;
    }

}