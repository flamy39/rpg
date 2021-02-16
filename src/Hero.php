<?php

class Hero
{
    public const POINTS_VIE_INITIAL = 250;

    private string $nom;
    private int $pointsVie;
    private int $energie;
    private int $agilite;
    private int $x;
    private int $y;

    /**
     * Hero constructor.
     * @param string $nom
     * @param int $energie
     */
    public function __construct(string $nom, int $energie, int $x, int $y)
    {
        $this->nom = $nom;
        $this->pointsVie = self::POINTS_VIE_INITIAL;
        $this->energie = ($energie>=1 && $energie<=5) ? $energie : rand(1,5);
        $this->agilite = 5 - $this->energie +1;
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

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }

    public function getInformations() : string {
        $informations = $this->nom . ' : ' . EspaceJeu::POSITION_HERO . ' ';
        $informations .= 'Position : (' . $this->x . ',' . $this->y . ')' . ' ';
        $informations .= 'PV : (' . $this->pointsVie . ')' . ' ';
        $informations .= 'E : (' . $this->energie . ')' . ' ';
        $informations .= 'A : (' . $this->agilite . ')' . ' ';
        return $informations;
    }





}