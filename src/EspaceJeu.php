<?php

require 'Couleurs.php';
require 'Hero.php';

class EspaceJeu {

    const POSITION_VIDE = '-';
    const POSITION_OBSTACLE = 'O';
    const POSITION_PERSONNAGE = 'P';
    const ESPACE_DEBUT_NUMEROS_COLONNE = '    ';
    const SEPARATEUR_POSITION = " | ";
    const LONGUEUR_TITRE = 80;
    public const POSITION_HERO = 'H';

    private int $longueur;
    private int $largeur;

    private ?Hero $hero = null;

    /**
     * EspaceJeu constructor.
     * @param int $longueur
     * @param int $largeur
     */
    public function __construct(int $longueur, int $largeur)
    {
        $this->longueur = ($longueur > 0) ? $longueur : 10;
        $this->largeur = ($largeur > 0) ? $largeur : 10;
    }

    public function visualiser() : string {
        $espaceJeuString = $this->visualiserInformations();
        $espaceJeuString .= $this->visualiserMap();
        $espaceJeuString .= $this->visualiserPanneauControle();
        return $espaceJeuString;
    }

    public function positionnerHero(string $nom, int $energie, int $x, int $y) {

        if ($this->estDansEspaceJeu($x, $y))
            $this->hero = new Hero($nom,$energie,$x,$y);
        else
            $this->hero = new Hero($nom,$energie,rand(0,$this->longueur-1),rand(0,$this->largeur-1));
    }

    /**
     * @return string
     */
    private function visualiserInformations(): string
    {
        $informations = $this->visualiserTitre('INFOS MAP','-',Couleurs::GREEN);
        $informations .= 'Dimensions map : (' . $this->longueur.','.$this->largeur.')'.PHP_EOL;
        $informations .= 'Vide : ' . Couleurs::YELLOW . self::POSITION_VIDE . Couleurs::RESET . PHP_EOL;
        $informations .= ($this->existeHero()) ? $this->hero->getInformations().PHP_EOL : 'Hero : ' . self::POSITION_HERO .PHP_EOL;
        $informations .= 'Obstacle : ' . self::POSITION_OBSTACLE . PHP_EOL;
        $informations .= 'Personnage : ' . self::POSITION_PERSONNAGE . PHP_EOL;
        return $informations;
    }

    /**
     * @return string
     */
    private function visualiserMap(): string
    {
        $map = $this->visualiserTitre('MAP','-',Couleurs::GREEN);
        $map .= $this->visualiserNumerosColonne();
        $map .= $this->visualiserLignes($map);
        return $map;
    }

    /**
     * @return string
     */
    private function visualiserNumerosColonne(): string
    {
        $numerosColonne = self::ESPACE_DEBUT_NUMEROS_COLONNE;
        for ($x = 0; $x < $this->longueur; $x++) {
            $numerosColonne .= Couleurs::BLUE . sprintf('  %02d', $x) . Couleurs::RESET;
        }
        $numerosColonne .= PHP_EOL;
        return $numerosColonne;
    }

    /**
     * @return string
     */
    private function visualiserLignes(): string
    {
        $lignes = '';
        for ($y = 0; $y < $this->largeur; $y++) {
            $lignes .= $this->visualiserLigne($y);
        }
        return $lignes;
    }

    /**
     * @param int $numeroLigne
     * @return string
     */
    private function visualiserLigne(int $numeroLigne): string
    {
        $ligne = Couleurs::BLUE . sprintf('  %02d', $numeroLigne) . Couleurs::RESET;
        for ($x = 0; $x < $this->longueur; $x++) {
            $ligne .= self::SEPARATEUR_POSITION. $this->recupererMarquePosition($x, $numeroLigne);
        }
        $ligne .= self::SEPARATEUR_POSITION . PHP_EOL;
        return $ligne;
    }

    /**
     * @return string
     */
    private function visualiserPanneauControle(): string
    {
        $panneauControle = $this->visualiserTitre('PANNEAU CONTROLE','-',Couleurs::GREEN);

        return $panneauControle;
    }

    /**
     * @param string $texte
     * @param string $caractereRemplissage
     * @param string $couleur
     * @return string
     */
    private function visualiserTitre(string $texte, string $caractereRemplissage, string $couleur) : string {
        $titre = '';

        $longueurRemplissage = self::LONGUEUR_TITRE - strlen($texte);
        if ($longueurRemplissage <= 0) {
            return $texte;
        }
        $longueurRemplissageGauche = round($longueurRemplissage / 2);
        $titre .= str_repeat($caractereRemplissage,$longueurRemplissageGauche);
        $titre .= Couleurs::YELLOW . $texte . Couleurs::RESET;
        $titre .= str_repeat($caractereRemplissage,$longueurRemplissageGauche);
        $titre .= PHP_EOL;
        return $titre;
    }

    /**
     * @return bool
     */
    private function existeHero(): bool
    {
        //return $this->hero !== null;
        return !is_null($this->hero);
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    private function existeHeroEnPosition(int $x, int $y): bool
    {
        return $this->existeHero() && $this->hero->occupePosition($x, $y) === true;
    }

    /**
     * @param int $x
     * @param int $y
     * @return string
     */
    private function recupererMarquePosition(int $x, int $y): string
    {
        $marque = '';
        if ($this->existeHeroEnPosition($x, $y)) {
            $marque = self::POSITION_HERO;
        } else {
            $marque = self::POSITION_VIDE;
        }
        return $marque;
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    private function estDansEspaceJeu(int $x, int $y): bool
    {
        return ($x >= 0 && $x < $this->longueur) && ($y >= 0 && $y < $this->largeur);
    }


}