<?php 

    class JSONView {
        public function response($body, $status = 200) {
            header("Content type: application/json");
            $statusText = $this->_requestStatus($status);
            header("HTTP/1.1 $status $statusText");
            echo json_encode($body);
        }

        # _ en una funcion para recordar q es privada
        private function _requestStatus($code) {
            $status = array(
                200 => "OK",
                201 => "Created",
                202 => "Accepted",
                204 => "No Content",
                301 => "Moved Permanently",
                302 => "Found",
                400 => "Bad Request",
                401 => "Unauthorized",
                403 => "Forbidden",
                404 => "Not Found",
                410 => "Gone",
                500 => "Internal Server Error",
                503 => "Service Unavailable"
            );
            return (isset($status[$code])) ? $status[$code] : $status[500];
        }
    }
        /* si existe la clave del codigo (si esta entre esos posibles del array) devuelve justamente el texto que contiene
        sino devuelve siempre el 500
        es una sentencia tipo if con else o case con default pero abreviada
        es lo mismo que hacer:
            if(!isset($status[$code])) {
                $code = 500;
            }
            return $status[$code]; */