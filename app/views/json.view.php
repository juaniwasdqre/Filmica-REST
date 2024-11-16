<?php 

    class JSONView {
        public function response($body, $status = 200) {
            header("Content-Type: application/json");
            $statusText = $this->_requestStatus($status);
            header("HTTP/1.1 $status $statusText");
            echo json_encode($body);
        }

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
