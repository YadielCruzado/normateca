<?php
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/db/db_info.php');
class AdminModel extends DB{

    public function getCategorias(){

        $query = "SELECT categories.Category_abbr, categories.Category_name, cuerpos.Cuerpo_name, cuerpos.Cuerpo_abbr
        FROM categories
        JOIN cuerpos ON categories.Cuerpo = cuerpos.Cuerpo_abbr
        ORDER BY cuerpos.Cuerpo_name ASC";
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

    public function enlazarDocumentos(){

        $query = "SELECT documentos.Certification_number, documentos.Fiscal_year, documentos.Document_title, categories.Category_name
        FROM documentos
        JOIN categories ON categories.Category_abbr = documentos.Category_abbr";
        return $this->run_query($query);
    }

    public function enlazarDocumentos1($cuerpo){

        $query = "SELECT documentos.Certification_number, documentos.Fiscal_year, documentos.Document_title, categories.Category_name
        FROM documentos
        JOIN categories ON categories.Category_abbr = documentos.Category_abbr
        WHERE documentos.Cuerpo_abbr = $cuerpo";
        return $this->run_query($query);
    }



    public function  getdocinfo(){
        
        $query = "SELECT Document_title, Date_created,Document_id FROM documentos ";
        return $this ->run_query($query);
    }

    public function updateDocument($documentId, $newName, $newDate) {
        
        $query = "UPDATE documentos SET Document_title = '$newName', Date_created = '$newDate' WHERE Document_id = '$documentId'";
        return $this ->run_query($query);
    }

    public function NewCategory($categoria,$Abreviacion,$cuerpo) {
        $query = "INSERT INTO categories 
        (Category_abbr, Category_name, Cuerpo) 
        VALUES ('".$Abreviacion . "','". $categoria . "','". $cuerpo."')";
        return $this->run_query($query);

    }

    public function NewCuerpo($cuerpo,$Abreviacion) {
        $query = "INSERT INTO cuerpos (Cuerpo_abbr, Cuerpo_name) 
        VALUES ('".$Abreviacion . "','". $cuerpo ."')";
        return $this->run_query($query);

    }

    public function updateCuerpo($cuerpo, $Abreviacion,$oldabbr) {
        $query = "UPDATE cuerpos SET Cuerpo_abbr = '$Abreviacion', Cuerpo_name = '$cuerpo' 
                  WHERE Cuerpo_abbr = '$oldabbr'";
        return $this->run_query($query);
    }
    public function updateACuerpo($Abreviacion, $oldabbr){
        $query = "UPDATE `categories` SET `Cuerpo` = '$Abreviacion' 
        WHERE `Cuerpo` = '$oldabbr'";
        return $this->run_query($query);
    }

    public function updateCategory($categoria,$Abreviacion,$cuerpo,$oldabbr) {
        $query = "UPDATE categories SET Category_abbr = '$Abreviacion', Category_name = '$categoria', Cuerpo = '$cuerpo'
                  WHERE Category_abbr = '$oldabbr'";
        return $this->run_query($query);
    }
}
?>