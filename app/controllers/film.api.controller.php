<?php
require_once './app/models/film.model.php';
require_once './app/views/json.view.php';

require_once './app/models/director.model.php';

class FilmApiController {

    private $view;
    private $model;
    private $authHelper;
    private $directorModel;

    public function __construct() {
        $this->model = new FilmModel();
        $this->view = new JSONView();
        $this->authHelper = new AuthApiHelper;

        $this->directorModel = new DirectorModel();
    }

    //1. LISTAR
    public function getAll($req, $res) {

        $genero = null;
        if(isset($req->query->genero)) {
            $genero = $req->query->genero;
        } 

        $orderBy = null;
        if(isset($req->query->orderBy))
            $orderBy = $req->query->orderBy;

        $direction = null;
        if(isset($req->query->direction)){
            $direction  = $req->query->direction;
        }
        
        $films = $this->model->getFilms($genero, $orderBy, $direction);
        
        if(!$films){ 
            return $this->view->response('No existen peliculas', 404);
        }
        
        return $this->view->response($films , 200);
    }

    public function get($req, $res) {
        $id = $req->params->id;

        $film = $this->model->getFilm($id);

        if(!$film) {
            return $this->view->response("La pelicula con el id=$id no existe", 404);
        }

        return $this->view->response($film);
    }

    //2. AGREGAR
    public function create($req, $res) {
        $user = $this->authHelper->currentUser();
        if(!$user){
            return $this->view->response('No esta autorizado', 401);
        }

        if($user->username!='webadmin'){
            return $this->view->response('No es un administrador', 403);
        }

        if (empty($req->body->titulo) || empty($req->body->id_director) || empty($req->body->genero) || empty($req->body->year || empty($req->body->sinopsis))) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $titulo = $req->body->titulo; 
        $id_director = $req->body->id_director; 
        $genero = $req->body->genero; 
        $year = $req->body->year; 
        $sinopsis = $req->body->sinopsis; 

        $id = $this->model->insertFilm($titulo, $id_director, $genero, $year, $sinopsis);

        if (!$id) {
            return $this->view->response("Error al insertar tarea", 500);
        }

        $film = $this->model->getFilm($id);
        return $this->view->response($film, 201);
    }

    //3. MODIFICAR
    public function update($req, $res) {
        $user = $this->authHelper->currentUser();
        if(!$user){
            return $this->view->response('No esta autorizado', 401);
        }

        if($user->username!='webadmin'){
            return $this->view->response('No es un administrador', 403);
        }
        
        $id = $req->params->id;

        $film = $this->model->getFilm($id);

        if(!$film){
            return $this->view->response('La película no existe', 404);
        }

        if (empty($req->body->titulo) || empty($req->body->id_director) || empty($req->body->genero) || empty($req->body->year || empty($req->body->sinopsis))) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $titulo = $req->body->titulo; 
        $id_director = $req->body->id_director; 
        $genero = $req->body->genero; 
        $year = $req->body->year; 
        $sinopsis = $req->body->sinopsis; 

        $this->model->modifyFilm($id,$titulo,$id_director,$genero,$year,$sinopsis);

        $film = $this->model->getFilm($id);
        return $this->view->response($film, 200);
    }

    //4. ELIMINAR
    public function delete($req, $res) {
        $id = $req->params->id;

        $film = $this->model->getFilm($id);

        if(!$film){
            return $this->view->response('La película no existe', 404);
        }

        $this->model->eraseFilm($id);

        return $this->view->response('La película se eliminó con éxito');
    }
}