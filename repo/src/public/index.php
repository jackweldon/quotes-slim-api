<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

spl_autoload_register(function ($classname) {
	if (is_file('../classes/'.$classname.'.php')) {
        require_once('../classes/'.$classname.'.php');
    }
});

$config['displayErrorDetails'] = false;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "sql11.freesqldatabase.com";
$config['db']['user']   = "sql11176110";
$config['db']['pass']   = "M7GFaEaLkS";
$config['db']['dbname'] = "sql11176110";

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/quotes', function (Request $request, Response $response) {
    $this->logger->addInfo("Quote list");
    $mapper = new QuoteMapper($this->db);
    $tickets = $mapper->getQuotes();
	
    return $response->withJson($tickets);
});


$app->get('/quotes/{type}', function (Request $request, Response $response, $args) {
    $ticket_id = (int)$args['type'];
    $mapper = new QuoteMapper($this->db);
    $ticket = $mapper->getQuotesByType($ticket_id);
    return $response->withJson($ticket);
});
$app->run();