<?php
require_once "Dice.php";

class Game {

    private array $dice = [];
    private int $throwCount = 0;
    private array $scores = [];
    const MAX_THROWS = 3;

    public function __construct() {
        for ($i = 0; $i < 5; $i++) {
            $this->dice[] = new Dice();
        }
    }

    public function canThrow(): bool {
        return $this->throwCount < self::MAX_THROWS;
    }

    public function throwAllDice() {
        if (!$this->canThrow()) return;

        $this->throwCount++;

        $values = [];
        foreach ($this->dice as $dice) {
            $dice->throwDice();
            $values[] = $dice->getFaceValue();
        }

        $this->scores[] = $values;
    }

    public function getResults(): array {
        return $this->scores;
    }

    public function getThrowCount(): int {
        return $this->throwCount;
    }

    public function allEqual($lastThrow): bool {
        return count(array_unique($lastThrow)) === 1;
    }
}
