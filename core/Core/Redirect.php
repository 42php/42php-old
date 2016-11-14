<?php

namespace           Core;

/**
 * Gère les redirections.
 *
 * Class Redirect
 * @package Core
 */
class				Redirect {
    /**
     * Effectue une redirection permanente (redirection 301)
     *
     * @param string $to    Destination
     */
    public static function	permanent($to) {
        header('HTTP/1.1 301 Moved Permanently', false, 301);
        self::http($to);
    }

    /**
     * Effectue une redirection temporaire (redirection 302)
     *
     * @param string $to    Destination
     */
    public static function	http($to) {
        Session::save();
        header("Location: $to");
        die();
    }
}