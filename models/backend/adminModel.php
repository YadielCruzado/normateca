<?php
include_once("../db/db_info.php");
class AdminModel extends DB
{
    public function getCategorias()
    {
        $query = "SELECT * FROM categories";
        return $this->run_query($query);
    }

    public function getCuerpos()
    {
        $query = "SELECT * FROM cuerpos";
        return $this->run_query($query);
    }


    public function  getdocinfo()
    {
        $query = "SELECT Document_title, Date_created FROM Documents";
        return $this ->run_query($query);
    }

}