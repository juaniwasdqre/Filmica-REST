<?php

class FilmModel {

    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=db_pelis;charset=utf8', 'root', '');
    }


    //1. LISTAR

    function getFilms($orderBy = false, $direction = 'ASC'){
        $sql = 'SELECT * FROM peliculas';

        if ($orderBy) {
            switch ($orderBy) {
                case 'id':
                    $sql .= ' ORDER BY id';
                    break;
                case 'titulo':
                    $sql .= ' ORDER BY titulo';
                    break;
                case 'year':
                    $sql .= ' ORDER BY year';
                    break;
                case 'genero':
                    $sql .= ' ORDER BY genero';
                    break;
                case 'id_director':
                    $sql .= ' ORDER BY id_director';
                    break;
                case 'sinopsis':
                    $sql .= ' ORDER BY sinopsis';
                    break;
            }
        }

        if ($direction) {
            switch ($direction) {
                case 'DESC':
                    $sql .= ' DESC';
                    break;
                case 'ASC':
                    $sql .= ' ASC';
                    break;
            }
        }

        // 2. Ejecuto la consulta
        $query = $this->db->prepare($sql);
        $query->execute();

        // 3. Obtengo los datos en un arreglo de objetos
        $tasks = $query->fetchAll(PDO::FETCH_OBJ);

        return $tasks;
    }

    public function getFilm($id) {    
        $query = $this->db->prepare('SELECT * FROM peliculas WHERE id = ?');
        $query->execute([$id]);   
    
        $film = $query->fetch(PDO::FETCH_OBJ);
    
        return $film;
    }

    public function getFilmsByGenre($genre) {
        $query = $this->db->prepare('SELECT * FROM peliculas WHERE genero = ?');
        $query->execute([$genre]);

        $films = $query->fetchAll(PDO::FETCH_OBJ);

        return $films;
    }

    function getFilmsWithDirectorName(){

        $query = $this->db->prepare('SELECT peliculas.*, director.nombre FROM peliculas INNER JOIN director ON peliculas.id_director = director.id ORDER BY `peliculas`.`titulo` ASC');
        $query->execute();

        $films = $query->fetchAll(PDO::FETCH_OBJ);
        return $films;
    }

    function getFilmByDirector($id_director){
        // 2. Ejecuto la consulta
        $query = $this->db->prepare('SELECT * FROM peliculas WHERE id_director = ?');
        $query->execute([$id_director]);
    
        // 3. Obtengo los datos en un arreglo de objetos
        $films = $query->fetchAll(PDO::FETCH_OBJ); 
    
        return $films;
    }

    public function getTop5(){
        $query = $this->db->prepare('SELECT * FROM `peliculas` ORDER BY `year` DESC LIMIT 5');
        $query->execute();

        $top5 = $query->fetchAll(PDO::FETCH_OBJ); 
        return $top5;
    }

    function getDirectorIdByFilm($id){
        $query = $this->db->prepare('SELECT id_director FROM peliculas WHERE id = ?');
        $query->execute([$id]);
     
         // 3. Obtengo los datos en un arreglo de objetos
         $id_director = $query->fetchAll(PDO::FETCH_OBJ); 
     
         return $id_director;
    }


    //2. AGREGAR
 
    function insertFilm($title, $id_director, $genero, $year, $sinopsis) { 
        $query = $this->db->prepare('INSERT INTO peliculas(titulo, id_director, genero, year, sinopsis) VALUES (?, ?, ?, ?, ?)');
        $query->execute([$title, $id_director, $genero, $year, $sinopsis]);
    
        $id = $this->db->lastInsertId();

        return $id;
    }


    //3. MODIFICAR

    function modifyFilm($id, $title, $id_director, $genre, $year, $synopsis) {        
        $query = $this->db->prepare('UPDATE peliculas SET titulo=?, id_director=?, genero=?, year=?, sinopsis=? WHERE id = ?');
        $query->execute([$title, $id_director, $genre, $year, $synopsis, $id]);

        return $id;
    }

    
    //4. ELIMINAR

    function eraseFilm($film){
        $query = $this->db->prepare('DELETE FROM peliculas WHERE id = ?');
        $query->execute([$film]);
    }   
}