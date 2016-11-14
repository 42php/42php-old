<?php

namespace                           Core;

class                               Number {
    /**
     * Calcule un pourcentage
     *
     * @param float $full           Valeur haute
     * @param float $minus          Valeur basse
     * @param int $round            Chiffres après la virgule
     *
     * @return float                Pourcentage
     */
    public static function          percent($full, $minus, $round = 2) {
        return round($minus / $full * 100, $round);
    }
}