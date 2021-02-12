<?php

require 'EspaceJeu.php';
require 'Utils.php';

$espaceJeu = new EspaceJeu(15,15);
Utils::effacerEcran();
echo  $espaceJeu->visualiser();
$espaceJeu->positionnerHero(11,12);
Utils::effacerEcran();
echo  $espaceJeu->visualiser();

