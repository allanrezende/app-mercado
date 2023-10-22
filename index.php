<?php

require __DIR__ . "/vendor/autoload.php";

use AllanRezende\AppMercado\Controllers\VendaController;
use AllanRezende\AppMercado\Core\App;
use AllanRezende\AppMercado\Core\Request;
use AllanRezende\AppMercado\Core\Response;

use AllanRezende\AppMercado\Controllers\ProdutoController;
use AllanRezende\AppMercado\Controllers\ProdutoTipoController;

use AllanRezende\AppMercado\Views\HomeView;

$app = new App();

# Home
$app->get('/', function(Request $request, Response $response){
    $homeView = new HomeView();
    $response->send($homeView->render());
});

# Tipo de produto
$app->get('/produto-tipo', function(Request $request, Response $response){
    $response->send(ProdutoTipoController::renderSearchView($request->getParams()));
});

$app->get('/produto-tipo/cadastro', function(Request $request, Response $response){
    $response->send(ProdutoTipoController::renderRegisterView($request->getParams()));
});

$app->post('/produto-tipo/cadastro', function(Request $request, Response $response){
    $params = $request->getParams();
    $produtoTipo = ProdutoTipoController::register($params);
    $response->redirect("/produto-tipo/cadastro", ["id" => $produtoTipo->getId(), "created" => true]);
});

$app->post('/produto-tipo/resultado-consulta', function (Request $request, Response $response){
    $params = $request->getParams();
    $response->send(ProdutoTipoController::renderSearchResultsView($params));
});

# Produto
$app->get('/produto', function(Request $request, Response $response){
    $response->send(ProdutoController::renderSearchView($request->getParams()));
});

$app->get('/produto/cadastro', function(Request $request, Response $response){
    $response->send(ProdutoController::renderRegisterView($request->getParams()));
});

$app->post('/produto/cadastro', function(Request $request, Response $response){
    $params = $request->getParams();
    $produto = ProdutoController::register($params);
    $response->redirect("/produto/cadastro", ["id" => $produto->getId(), "created" => true]);
});

# Venda
$app->get('/venda', function(Request $request, Response $response){
    $response->send(VendaController::renderSearchView($request->getParams()));
});
$app->get('/venda/cadastro', function(Request $request, Response $response){
    $response->send(VendaController::renderRegisterView($request->getParams()));
});

$app->run();