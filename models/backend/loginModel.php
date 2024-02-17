<?php
include_once("../../db/db_info.php");


class LoginModel extends DB
{
    public function getUser($email, $pwd)
    {
        $query = "SELECT * FROM admin WHERE Email = '$email' AND Password='$pwd'";
        return $this->run_query($query);
    }
}
?>