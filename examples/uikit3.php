<?php

use rauwebieten\twigformtemplates\TwigFormTemplates;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require_once __DIR__ . '/../vendor/autoload.php';

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/cache',
    'auto_reload' => true,
    'strict_variables' => true,
]);

(new TwigFormTemplates())->registerTemplates($twig);

print $twig->render('uikit3.twig',[]);
exit;