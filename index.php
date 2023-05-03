<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Model\Entity;
use App\Controller\AuthController;
use App\Controller\EntityController;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$logger = new Logger('app');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));

$entityManager = new Entity();

$app = AppFactory::create();
$app->setBasePath('/simple-blog');

$app->get('/', function (Request $request, Response $response) {
    $renderer = new PhpRenderer(__DIR__ . '/View/');
    return $renderer->render($response, 'home.php');
});

$authController = new AuthController($app, $entityManager, $logger);
$app->get('/login', [$authController, 'getLogin'])->setName('login');
$app->post('/login', [$authController, 'postLogin']);

$app->get('/signup', [$authController, 'getSignup'])->setName('signup');
$app->post('/signup', [$authController, 'postSignup']);

$entityController = new EntityController($app, $entityManager, $logger);
$app->get('/entity/create', [$entityController, 'getCreate'])->setName('create-entity');
$app->post('/entity/create', [$entityController, 'postCreate']);

$app->get('/entity/{id:[0-9]+}', [$entityController, 'getView'])->setName('view-entity');

$app->get('/entity/{id:[0-9]+}/edit', [$entityController, 'getEdit'])->setName('edit-entity');
$app->post('/entity/{id:[0-9]+}/edit', [$entityController, 'postEdit']);

$app->get('/entity/{id:[0-9]+}/delete', [$entityController, 'getDelete'])->setName('delete-entity');
$app->post('/entity/{id:[0-9]+}/delete', [$entityController, 'postDelete']);

$app->run();