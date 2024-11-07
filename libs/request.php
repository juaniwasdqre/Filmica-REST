<?php
    class Request {
        public $body = null; # { nombre: 'Saludar', descripcion: 'Saludar a todos'}
        public $params = null; # /api/peliculas/:id
        public $query = null; # ?soloHorror=true

        public function __construct() {
            try {
                #file_get_contents('php://input') lee el body de la request (propio de php)
                $this->body = json_decode(file_get_contents('php://input'));
            }
            catch (Exception $e) {
                $this->body = null;
            }
            $this->query = (object) $_GET;
            //el (object) es para poder manipularlo como:
                #$this->query->soloHorror
            
        }
    }