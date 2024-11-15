<?php
    require_once 'libs/router.php';
    require_once 'app/controllers/film.api.controller.php';

    $router = new Router();

    #                  endpoint     verbo      controller        metodo
    $router->addRoute('peliculas'     , 'GET', 'FilmApiController', 'getAll');
    $router->addRoute('pelicula/:id'  , 'GET', 'FilmApiController', 'get');
    $router->addRoute('pelicula/:id'  , 'DELETE', 'FilmApiController', 'delete');
    $router->addRoute('pelicula'  , 'POST', 'FilmApiController', 'create');
    $router->addRoute('pelicula/:id'  , 'PUT', 'FilmApiController', 'update');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);