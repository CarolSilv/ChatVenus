<?php
namespace App\Routes;

use App\Controllers\UsuarioController;
use Slim\Factory\AppFactory;

$app = AppFactory::create();


$app->get('/',UsuarioController::class.':apiRun');
$app->post('/auth',UsuarioController::class.':autenticarUsuario');
$app->post('/cadastrarUsuario',UsuarioController::class.':cadastrarUsuario');
$app->post('/cadastrarContato/[{CHAVE_SECRETA}]',UsuarioController::class.':cadastrarContatos');
$app->get('/buscarContatos/[{CHAVE_SECRETA}]',UsuarioController::class.':buscarContatos');
$app->delete('/excluirContato/[{CHAVE_SECRETA}]',UsuarioController::class.':excluirContato');


$app->run();