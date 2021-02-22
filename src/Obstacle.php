<?php


class Obstacle
{
    private bool $franchissable;
    private int $x;
    private int $y;
    private int $bonus;

    /**
     * Obstacle constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        $this->franchissable = rand(1,100) % 2 === 0;
        $this->x = $x;
        $this->y = $y;
        $this->bonus = ($this->franchissable) ? rand(-10,10) : 0;
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    public function occupePosition(int $x, int $y) : bool
    {
        return $this->x === $x && $this->y === $y;
    }

    /**
     * @return int
     */
    public function getBonus(): int
    {
        return $this->bonus;
    }


}