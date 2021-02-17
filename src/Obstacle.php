<?php


class Obstacle
{
    private bool $franchissable;
    private int $x;
    private int $y;
    private int $bonus;

    /**
     * Obstacle constructor.
     * @param bool $franchissable
     * @param int $x
     * @param int $y
     */
    public function __construct(bool $franchissable, int $x, int $y)
    {
        $this->franchissable = $franchissable;
        $this->x = $x;
        $this->y = $y;
        $this->bonus = ($franchissable) ? rand(-10,10) : 0;
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