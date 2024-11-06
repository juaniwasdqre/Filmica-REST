<?php
    require_once 'libs/router.php';
    require_once 'app/controllers/film.api.controller.php';

    $router = new Router();

    #                  endpoint          verbo     controller        metodo
    $router->addRoute('peliculas'      , 'GET', 'filmApiController', 'getAll');
    $router->addRoute('peliculas/:id'  , 'GET', 'filmApiController', 'get');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);