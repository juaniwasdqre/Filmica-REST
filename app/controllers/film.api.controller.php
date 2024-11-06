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

        $orderBy = null;
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        $direction = null;
        if(isset($req->query->direction)){
            $direction  = $req->query->direction;
        }

        $films = $this->model->getFilms($orderBy, $direction);

        if(!$films){ 
            return $this->view->response('No existen peliculas', 404);
        }
        return $this->view->response($films , 200);
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

    public function delete($req, $res) {
        //obtengo el id de la pelicula desde la ruta
        $id = $req->params->id;

        //obtengo la pelicula de la DB
        $film = $this->model->getFilm($id);

        if(!$film){
            return $this->view->response('La película no existe', 404);
        }

        $this->model->eraseFilm($id);

        //mando la pelicula a la vista
        return $this->view->response('La película se eliminó con éxito');
    }
}