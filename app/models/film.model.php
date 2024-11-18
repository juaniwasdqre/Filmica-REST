<?php

class FilmModel {

    private $db;

    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;dbname=db_pelis;charset=utf8', 'root', '');
    }


    //1. LISTAR
    function getFilms($genero=null, $orderBy=null, $direction=null){
        $sql = 'SELECT * FROM peliculas';

        if ($genero) {
            switch ($genero) {
                case stristr($genero, 'Drama'):
                    $sql .= ' WHERE genero = "Drama"';
                    break;
                case stristr($genero, 'Horror'):
                    $sql .= ' WHERE genero = "Horror"';
                    break;
                case stristr($genero, 'Comedia'):
                    $sql .= ' WHERE genero = "Comedia"';
                    break;
                case stristr($genero, 'Romance'):
                    $sql .= ' WHERE genero = "Romance"';
                    break;
                case stristr($genero, 'Accion'):
                    $sql .= ' WHERE genero = "Accion"';
                    break;
                case stristr($genero, 'Aventura'):
                    $sql .= ' WHERE genero = "Aventura"';
                    break;
                case stristr($genero, 'Documental'):
                    $sql .= ' WHERE genero = "Documental"';
                    break;
                case stristr($genero, 'Fantasia'):
                    $sql .= ' WHERE genero = "Fantasia"';
                    break;
            }
        }

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

        $query = $this->db->prepare($sql);
        $query->execute();

        $films = $query->fetchAll(PDO::FETCH_OBJ);

        return $films;
    }

    function getFilmsPaginado($genero=null, $orderBy=null, $direction=null, $pagina=1, $limit){
        $sql = 'SELECT * FROM peliculas';

        if ($genero) {
            switch ($genero) {
                case stristr($genero, 'Drama'):
                    $sql .= ' WHERE genero = "Drama"';
                    break;
                case stristr($genero, 'Horror'):
                    $sql .= ' WHERE genero = "Horror"';
                    break;
                case stristr($genero, 'Comedia'):
                    $sql .= ' WHERE genero = "Comedia"';
                    break;
                case stristr($genero, 'Romance'):
                    $sql .= ' WHERE genero = "Romance"';
                    break;
                case stristr($genero, 'Accion'):
                    $sql .= ' WHERE genero = "Accion"';
                    break;
                case stristr($genero, 'Aventura'):
                    $sql .= ' WHERE genero = "Aventura"';
                    break;
                case stristr($genero, 'Documental'):
                    $sql .= ' WHERE genero = "Documental"';
                    break;
                case stristr($genero, 'Fantasia'):
                    $sql .= ' WHERE genero = "Fantasia"';
                    break;
            }
        }

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

        
        // SE AGREGA CODIGO PARA PAGINAR CORRECTAMENTE:

        // se define el offset (desde donde arranca a traer datos)
        # se calcula como cantidadDeDatos x pagina
        # la tabla arranca desde 0 pero el usuario arrancaria desde 1 por lo tanto pagina-1
        $offset = ($pagina-1)*$limit;
        $sql .= " LIMIT :limit OFFSET :offset";

        $query = $this->db->prepare($sql);

        # bindValue para poder insertar los valores requeridos
        # PARAM_INT para verificar que son integers, de lo contrario daria false y error.
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset',$offset, PDO::PARAM_INT);
        // De esta manera evitamos inyecciones de codigo malicioso.
        
        //Una vez finalizados los checkeos de todos los posibles parametros a requerir, se ejecuta la query
        $query->execute();
        $films = $query->fetchAll(PDO::FETCH_OBJ);

        return $films;
    }

    function countRows() {
        $query = $this->db->prepare('SELECT COUNT(*) as total FROM peliculas');
        $query->execute();

        $total = $query->fetch(PDO::FETCH_NUM);

        return $total[0];
    }

    function getFilm($id) {
        $query = $this->db->prepare('SELECT * FROM peliculas WHERE id = ?');
        $query->execute([$id]);   
    
        $film = $query->fetch(PDO::FETCH_OBJ);
    
        return $film;
    }

    function getFilmsWithDirectorName(){

        $query = $this->db->prepare('SELECT peliculas.*, director.nombre FROM peliculas INNER JOIN director ON peliculas.id_director = director.id ORDER BY `peliculas`.`titulo` ASC');
        $query->execute();

        $films = $query->fetchAll(PDO::FETCH_OBJ);
        return $films;
    }

    function getFilmByDirector($id_director){
        $query = $this->db->prepare('SELECT * FROM peliculas WHERE id_director = ?');
        $query->execute([$id_director]);

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
     
         $id_director = $query->fetchAll(PDO::FETCH_OBJ); 
     
         return $id_director;
    }


    //2. AGREGAR
 
    function insertFilm($titulo, $id_director, $genero, $year, $sinopsis) { 
        $query = $this->db->prepare('INSERT INTO peliculas(titulo, id_director, genero, year, sinopsis) VALUES (?, ?, ?, ?, ?)');
        $query->execute([$titulo, $id_director, $genero, $year, $sinopsis]);
    
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