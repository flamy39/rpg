<?php

require 'Couleurs.php';

class EspaceJeu {

    const POSITION_VIDE = '-';
    const POSITION_OBSTACLE = 'O';
    const POSITION_HERO = 'H';
    const POSITION_PERSONNAGE = 'P';
    const ESPACE_DEBUT_NUMEROS_COLONNE = '    ';
    const SEPARATEUR_POSITION = " | ";
    const LONGUEUR_TITRE = 80;

    private int $longueur;
    private int $largeur;

    /**
     * EspaceJeu constructor.
     * @param int $longueur
     * @param int $largeur
     */
    public function __construct(int $longueur, int $largeur)
    {
        $this->longueur = $longueur;
        $this->largeur = $largeur;
    }

    public function visualiser() : string {
        $espaceJeuString = $this->visualiserInformations();
        $espaceJeuString .= $this->visualiserMap();
        $espaceJeuString .= $this->visualiserPanneauControle();
        return $espaceJeuString;
    }

    /**
     * @return string
     */
    private function visualiserInformations(): string
    {
        $informations = $this->visualiserTitre('INFOS MAP','-',Couleurs::GREEN);
        $informations .= 'Dimensions map : (' . $this->longueur.','.$this->largeur.')'.PHP_EOL;
        $informations .= 'Vide : ' . Couleurs::YELLOW . self::POSITION_VIDE . Couleurs::RESET . PHP_EOL;
        $informations .= 'Héro : ' . self::POSITION_HERO . PHP_EOL;
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

        for ($y = 0; $y < $this->largeur; $y++) {
            $map .= $this->visualiserLigneMap($y);
        }

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
     * @param int $numeroLigne
     * @return string
     */
    private function visualiserLigneMap(int $numeroLigne): string
    {
        $ligne = Couleurs::BLUE . sprintf('  %02d', $numeroLigne) . Couleurs::RESET;
        for ($x = 0; $x < $this->longueur; $x++) {
            $ligne .= self::SEPARATEUR_POSITION . Couleurs::YELLOW .self::POSITION_VIDE . Couleurs::RESET;
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
}