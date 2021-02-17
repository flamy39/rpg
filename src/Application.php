<?php

require 'EspaceJeu.php';
require 'Utils.php';

$espaceJeu = new EspaceJeu(15,15);
Utils::effacerEcran();
$espaceJeu->positionnerObstacles();
$espaceJeu->positionnerHero("Aragorn",2,13,13);
echo  $espaceJeu->visualiser();

