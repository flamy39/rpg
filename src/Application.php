<?php

require 'EspaceJeu.php';
require 'Utils.php';

$espaceJeu = new EspaceJeu(15,15);
Utils::effacerEcran();
echo  $espaceJeu->visualiser();
