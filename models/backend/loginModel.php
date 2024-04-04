<?php
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/db/db_info.php');
class LoginModel extends DB{
    
    public function LoginUser($email, $password) {
        $query = "SELECT name, Last_name, Cuerpo, Admin_id FROM admin
        WHERE email = '$email' and password = '$password'";
        return $this->run_query($query);
    }
    
    public function getCuerpos(){

        $query = "SELECT * FROM cuerpos";
        return $this->run_query($query);
    }
}
?>