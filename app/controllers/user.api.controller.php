<?php
require_once './app/models/user.model.php';
require_once './app/views/json.view.php';
require_once './app/helpers/auth.api.helper.php';


class UserApiController {

    private $view;
    private $model;
    private $authApiHelper;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new JSONView();
        $this->authApiHelper = new AuthApiHelper();

    }

    function getToken($params = []){
        $basic = $this->authApiHelper->getAuthHeaders(); 

        if(empty($basic)){
            return $this->view->response('No envio encabezados de autenticacion', 401);
        }

        $basic = explode(" ", $basic); 

        if($basic[0]!="Basic"){
            $this->view->response('Los encabezados de autenticacion son incorrectos', 401);
            return;
        }

        $userpass = base64_decode($basic[1]);
        $userpass = explode(":", $userpass); 

        $username = $userpass[0];
        $password = $userpass[1];

        $usuario= $this->model->getUserByName($username);

        if($usuario && password_verify($password, $usuario->password)){
            $token = $this->authApiHelper->createToken($usuario);
            return $this->view->response($token, 200);
        }else {
            return $this->view->response('El nombre de usuario o contraseña son incorrectos', 401);
        }
    }

}

