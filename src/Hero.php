<?php

class Hero
{
    public const POSITION_HERO = 'H';
    private int $x;
    private int $y;

    /**
     * Hero constructor.
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
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
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }




}