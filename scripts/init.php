<?php

if (!defined('NO_BUFFER'))
    ob_start();

/** Define the ROOT. Used in all the system to have the working directory. */
define('ROOT', realpath(__DIR__.'/../'));

/** If HTTP_HOST isn't defined, we are in CLI environnement. */
if (!isset($_SERVER['SERVER_NAME']))
    $_SERVER['SERVER_NAME'] = 'cli';
if (!isset($_SERVER['SERVER_PORT']))
    $_SERVER['SERVER_PORT'] = 80;

/** If we are in CLI environnement, we create a fake REQUEST_URI from the $argv variable. */
if (!isset($_SERVER['REQUEST_URI'])) {
    if (isset($argv)) {
        $p = [];
        foreach ($argv as $i => $a)
            if ($i >= 1) {
                $p[] = str_replace('/', '__separator__', $a);
            }
        $_SERVER['REQUEST_URI'] = '/'.implode('/', $p);
    } else
        $_SERVER['REQUEST_URI'] = '/';
}

/** Call the autoloader. */
include_once __DIR__.'/autoload.php';

// Chargement de la configuration globale
$confToLoad = \Core\Dir::read(ROOT.'/config', true, '*.php');
foreach ($confToLoad as $file)
    include $file;
\Core\Conf::load(ROOT.'/config/global.json');

\Core\Debug::$TRACE_ENABLED = \Core\Conf::get('debug') && isset($_GET['trace']);

if (\Core\Conf::get('debug'))
    \Core\Conf::set('inspector.startTime', microtime(true));

if (\Core\Conf::get('debug', false)) {
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Initialisation de la session
\Core\Session::init();

// Initialisation du multilangue
\Core\i18n::init();

if (isset($_GET['lang']) && in_array($_GET['lang'],  \Core\i18n::$__acceptedLanguages)) {
    \Core\Conf::set('oldlang',  \Core\Conf::get('lang'));
    \Core\Conf::set('lang', $_GET['lang']);
}

\Core\i18n::load();

// Construction du tableau d'arguments
global $argv, $argc;
$argv = \Core\Argv::parse(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '', \Core\Conf::get('argv.offset'));
$argc = sizeof($argv);

\Core\Conf::set('url', \Core\Http::url());

// Page hash
global $argv;
$pageHash = '/'.implode('/', $argv);
if (sizeof($_GET))
    $pageHash .= '?' . http_build_query($_GET);
\Core\Conf::set('page.hash', sha1($pageHash));
