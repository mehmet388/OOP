<?php

class Dice {

    const NUMBER_OF_SIDES = 6;
    private int $faceValue;

    public function throwDice() {
        $this->faceValue = rand(1, self::NUMBER_OF_SIDES);
    }

    public function getFaceValue() {
        return $this->faceValue;
    }
}
