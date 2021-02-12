<?php


class Utils
{
    public static function effacerEcran() {
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
    }
}