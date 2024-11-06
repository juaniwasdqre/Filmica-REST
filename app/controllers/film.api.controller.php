<?php
require_once './app/models/film.model.php';
require_once './app/views/json.view.php';

require_once './app/models/director.model.php';

class FilmApiController {

    private $view;
    private $model;

    private $directorModel;

    public function __construct() {
        $this->model = new FilmModel();
        $this->view = new JSONView();

        $this->directorModel = new DirectorModel();
    }


    //1. LISTAR

    // /api/peliculas
    public function getAll($req, $res) {

        # /api/peliculas?genero=(valor)
        if(isset($req->query->genero)) {
            $films = $this->model->getFilmsByGenre($req->query->genero);
        } else {
            $films = $this->model->getFilms();
        }

        $this->view->response($films);
    }

    # /api/pelicula/:id
    public function get($req, $res) {
        #id de la pelicula desde la ruta
        $id = $req->params->id;

        #pelicula desde la DB
        $film = $this->model->getFilm($id);

        if(!$film) {
            return $this->view->response("La pelicula con el id=$id no existe", 404);
        }

        #mando la pelicula a la vista
        return $this->view->response($film);
    }

    //2. AGREGAR
    //3. MODIFICAR
    //4. ELIMINAR
}