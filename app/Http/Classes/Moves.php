<?php
/**
 * Created by PhpStorm.
 * User: Pramod
 * Date: 24/08/2015
 * Time: 2:49 PM
 * This Class is use to calculate
 * available moves for each animal
 * whose state is alive
 */

namespace app\Http\Classes;

use App\Http\Classes\Initiate;


class Moves
{
    private $gameState;
    private $allNextMovePosition = [];
    private $allNoMovePosition = [];

    private $allPositionWithAnimal;

    private $allAliveNextMoveAnimal;
    private $allAliveNoMoveAnimal;

    private $coOrdinateRange = [0, 1, 2, 3, 4];
    private $possibleMovement = [
        ['x' => 1, 'y' => 0], ['x' => -1, 'y' => 0], ['x' => 0, 'y' => 1],
        ['x' => 0, 'y' => -1], ['x' => 1, 'y' => 1], ['x' => -1, 'y' => -1],
        ['x' => 1, 'y' => -1], ['x' => -1, 'y' => 1]
    ];


    public function __construct(Initiate $gameState)
    {
        $this->gameState = $gameState;
        $this->abstractAllPosition();
        return $this;
    }


    private function abstractAllPosition()
    {
        foreach ($this->gameState->getAllPosition() as $pos) {
            $this->allPositionWithAnimal[$pos->getXCoordinate()][$pos->getYCoordinate()] = $pos->getAnimal()->getType();
//            ($pos->getAnimal()->getType() == $this->gameState->getNextMove()) ?
//                array_push($this->allNextMovePosition, $pos->getCoordinates()) :
//                array_push($this->allNoMovePosition, $pos->getCoordinates());


//            if ($pos->getAnimal()->getType() == $this->gameState->getNextMove())
//                $this->allAliveNextMoveAnimal[$pos->getXCoordinate()][$pos->getYCoordinate()] = $pos->getAnimal()->getType();
//            else
//                $this->allAliveNoMoveAnimal[$pos->getXCoordinate()][$pos->getYCoordinate()] = $pos->getAnimal()->getType();
        }
    }

    public function generateAllowedMoves()
    {
        $allowedMoves = [];
        switch ($this->gameState->getNextMove()) {
            case 'Goat':
                if ($this->gameState->getTotalSleepingGoat() > 0) {
                    $allowedMoves = ['PlaceGoat' => $this->generateForGoat()];
                } else {
                    $allowedMoves = $this->generateForAllAnimal();
                }
                break;
            case 'Tiger':
                $allowedMoves = $this->generateForAllAnimal(true);
                break;
        }

        return $allowedMoves;
    }

    private function generateForAllAnimal($tiger = false)
    {
        $return = [];
        foreach ($this->gameState->getAllPosition() as $pos) {
            if ($pos->getAnimal()->getType() == $this->gameState->getNextMove()) {
                $x = $pos->getXCoordinate();
                $y = $pos->getYCoordinate();
                $return[$x . ',' . $y] = $this->generateNextMove($x, $y, $tiger);
            }
        }
        return $return;
    }

    private function generateNextMove($x, $y, $tiger = false)
    {

        $return = [];
        foreach ($this->possibleMovement as $val) {
            $tempX = $x + $val['x'];
            $tempY = $y + $val['y'];
            if (
                in_array($tempX, $this->coOrdinateRange)
                && in_array($tempY, $this->coOrdinateRange)
                && $this->checkIfPositionIsEmpty($x + $val['x'], $y + $val['y'])
            ) {
                $return[] = ($tempX) . ',' . ($tempY);
            }


            if ($tiger && !$this->checkIfPositionIsEmpty($tempX, $tempY)) {
                if ($this->allPositionWithAnimal[$tempX][$tempY] == 'Goat') {
                    $findX = $tempX - $x ;
                    $findY = $tempY - $y;

                    $return[] = ($findX+$tempX).",". ($findY+$tempY);
                }
            }

        }

        return $return;
    }

    private function generateForGoat()
    {
        $return = [];
        for ($i = 0; $i < count($this->coOrdinateRange); $i++) {
            for ($j = 0; $j < count($this->coOrdinateRange); $j++) {
                if ($this->checkIfPositionIsEmpty($i, $j))
                    $return[] = $i . ',' . $j;
            }
        }

        return $return;
    }

    private function checkIfPositionIsEmpty($x, $y)
    {
        return (empty($this->allPositionWithAnimal[$x][$y])) ? true : false;
    }



}