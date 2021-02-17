<?php

require 'Couleurs.php';
require 'Hero.php';
require 'Obstacle.php';

class EspaceJeu {

    const POSITION_VIDE = '-';
    const POSITION_HERO = 'H';
    const POSITION_OBSTACLE = 'O';
    const POSITION_PERSONNAGE = 'P';
    const ESPACE_DEBUT_NUMEROS_COLONNE = '    ';
    const SEPARATEUR_POSITION = " | ";
    const LONGUEUR_TITRE = 80;

    private int $longueur;
    private int $largeur;

    private ?Hero $hero = null;

    /**
     * @var Obstacle[]
     */
    private array $obstacles = [];

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

    /**
     * @return string
     */
    public function visualiser() : string {
        $espaceJeuString = $this->visualiserInformations();
        $espaceJeuString .= $this->visualiserMap();
        $espaceJeuString .= $this->visualiserPanneauControle();
        return $espaceJeuString;
    }

    /**
     * @param string $nom
     * @param int $energie
     * @param int $x
     * @param int $y
     */
    public function positionnerHero(string $nom, int $energie, int $x, int $y) {

        if ( !$this->estDansEspaceJeu($x,$y))
            [$x, $y] = $this->genererPositionAleatoire();
        [$x, $y] = $this->genererPositionAleatoireVide($x, $y);
        $this->hero = new Hero($nom,$energie,$x,$y);

        /*if ($this->estDansEspaceJeu($x, $y) && $this->recupererMarquePosition($x,$y) === self::POSITION_VIDE)
            $this->hero = new Hero($nom,$energie,$x,$y);
        else {
            // Générer la position 
            $this->hero = new Hero($nom,$energie,rand(0,$this->longueur-1),rand(0,$this->largeur-1));
        }*/
    }

    /**
     *
     */
    public function positionnerObstacles() {
        // - Calculer le nombre d'obstacles
        $nombreObstacles = round($this->longueur * $this->largeur * 0.15);

        // - Placer les obstacles aléatoirement dans l'espace de jeu
        for($i=1; $i <= $nombreObstacles; $i++) {
            // -- Placer un obstacle
            // --- calculer aléatoirement la position de l'obstacle et verifier si la position est vide
            $obstacleX = rand(0,$this->longueur-1);
            $obstacleY = rand(0,$this->largeur-1);
           // echo sprintf("Obstacle %d : (%d,%d)",$i,$obstacleX,$obstacleY). PHP_EOL;
            while (  !($this->recupererMarquePosition($obstacleX,$obstacleY) === self::POSITION_VIDE))
            {
                $obstacleX = rand(0,$this->longueur-1);
                $obstacleY = rand(0,$this->largeur-1);
            }
            // --- créer l'obstacle avec la position calculée
            $franchissable = rand(1,100) % 2 === 0;
            //$bonus = ($franchissable) ? rand(1,10) : 0;
            $obstacle = new Obstacle($franchissable,$obstacleX,$obstacleY);
            // --- ajouter l'obstacleau tableau des obstacles
            $this->obstacles [] = $obstacle;
        }
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
        $informations .= 'Obstacle : ' . self::POSITION_OBSTACLE . ' (' . sizeof($this->obstacles) . ')' . ' Bonus : ('. $this->calculerBonusObstacles(). ')'.PHP_EOL;
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
        //$marque = '';
        if ($this->existeHeroEnPosition($x, $y)) {
            $marque = self::POSITION_HERO;
        } else if ($this->existeObstacleEnPosition($x,$y)) {
            $marque = self::POSITION_OBSTACLE;
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

    private function existeObstacleEnPosition(int $x, int $y)
    {
        for ($i=0; $i < sizeof($this->obstacles); $i++) {
            if ($this->obstacles[$i]->occupePosition($x,$y)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param int $x
     * @param int $y
     * @return array|int[]
     */
    private function genererPositionAleatoireVide(int $x, int $y): array
    {
        while (!$this->positionEstVide($x, $y)) {
            [$x, $y] = $this->genererPositionAleatoire();
        }
        return array($x, $y);
    }

    /**
     * @return array
     */
    private function genererPositionAleatoire(): array
    {
        $x = rand(0, $this->longueur - 1);
        $y = rand(0, $this->largeur - 1);
        return array($x, $y);
    }

    /**
     * @param int $x
     * @param int $y
     * @return bool
     */
    private function positionEstVide(int $x, int $y): bool
    {
        return ($this->recupererMarquePosition($x, $y) === self::POSITION_VIDE);
    }

    private function calculerBonusObstacles() : int {
        $bonus = 0;
        foreach ($this->obstacles as $obstacle) {
            $bonus += $obstacle->getBonus();
        }
        return $bonus;
    }
}