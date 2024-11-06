<?php
require_once './app/models/film.model.php';
require_once './app/view/json.view.php';

require_once './app/models/director.model.php';

class FilmController {

    private $view;
    private $model;

    private $directorModel;

    public function __construct() {
        $this->model = new FilmModel();
        $this->view = new JSONView();

        $this->directorModel = new DirectorModel();
    }


    //1. LISTAR

    public function getAll($req, $res) {
        $films = $this->model->getFilms();
        $this->view->response($films);
    }

    // /api/peliculas/:id
    public function get($req, $res) {
        //obtengo el id de la pelicula desde la ruta
        $id = $req->params->id;

        //obtengo la pelicula de la DB
        $film = $this->model->getFilm($id);

        //mando la pelicula a la vista
        return $this->view->response($film);
    }

    //2. AGREGAR
    //3. MODIFICAR
    //4. ELIMINAR
}