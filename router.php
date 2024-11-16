<?php
    require_once 'libs/router.php';
    require_once './config.php';
    require_once 'app/controllers/film.api.controller.php';
    require_once 'app/controllers/user.api.controller.php';

    $router = new Router();

    #                  endpoint     verbo      controller        metodo
    $router->addRoute('peliculas'     , 'GET', 'FilmApiController', 'getAll');
    $router->addRoute('pelicula/:id'  , 'GET', 'FilmApiController', 'get');
    $router->addRoute('pelicula/:id'  , 'DELETE', 'FilmApiController', 'delete');
    $router->addRoute('pelicula'  , 'POST', 'FilmApiController', 'create');
    $router->addRoute('pelicula/:id'  , 'PUT', 'FilmApiController', 'update');

    $router->addRoute('user/token'  , 'GET', 'UserApiController', 'getToken');

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);