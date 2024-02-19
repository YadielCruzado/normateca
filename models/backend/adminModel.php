<?php
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/db/db_info.php');
class AdminModel extends DB
{
    public function getCategorias(){

        $query = "SELECT * FROM categories";
        return $this->run_query($query);
    }

    public function getCuerpos(){

        $query = "SELECT * FROM cuerpos";
        return $this->run_query($query);
    }

    public function InsertFile($values){

        $query = "INSERT 
        INTO documentos (Document_title, Cuerpo_abbr, Category_abbr, Certification_number, Fiscal_year, Document_lenguaje, Document_path, Date_created, Document_state, Amended) 
        VALUES ('" . $values['file_name'] . "', '" . $values['file_corp'] . "', '" . $values['file_cat'] . "', '" . $values['file_number'] . "', '" . $values['file_year'] . "', '" . $values['file_lang'] . "', '" . $values['file_path'] . "', '" . $values['file_date'] . "', '" . $values['file_state'] . "', 0)";
        return $this->run_query($query);
    }
}
