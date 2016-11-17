<?php

include 'init.php';

if (function_exists('readline_completion_function')) {
    readline_completion_function(function ($input) {
        $scriptsDir = ROOT . '/scripts/cli/';
        $allScripts = \Core\Dir::read($scriptsDir, true, '*.php');
        $matches = [];

        foreach ($allScripts as $script) {
            $script = str_replace([$scriptsDir, '.php'], '', $script);
            if (stripos($script, $input) === 0)
                $matches[] = $script;
        }
        if (!sizeof($matches))
            $matches[] = '';

        return $matches;
    });
}

ob_end_flush();

if ($_SERVER['SERVER_NAME'] != 'cli') {
    echo _t("Ce script doit être exécuté via le bash")."\n";
    die();
}

global $argc, $argv;

if ($argc < 1) {
    echo _t("Une tâche doit être spécifiée")."\n";
    die();
}

var_dump($argv);

$task = $argv[0];

if (!file_exists(ROOT.'/scripts/cli/'.$task.'.php')) {
    echo _t("La tâche sélectionnée n'existe pas")."\n";
    die();
}

echo "\n\n-----------\n";

$task_start = microtime(true);

include ROOT.'/scripts/cli/'.$task.'.php';

$task_end = microtime(true);

if (($task_end - $task_start) * 1000 > 60000)
    echo "-----------\n\n"._t("Tâche exécutée en")." ".round(($task_end - $task_start) / 60, 0)."min ".round(($task_end - $task_start) % 60, 0)."s.\n";
elseif (($task_end - $task_start) * 1000 > 2000)
    echo "-----------\n\n"._t("Tâche exécutée en")." ".round($task_end - $task_start, 2)."s.\n";
else
    echo "-----------\n\n"._t("Tâche exécutée en")." ".round(($task_end - $task_start) * 1000, 2)."ms.\n";