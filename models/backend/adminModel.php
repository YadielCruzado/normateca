<?php
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/db/db_info.php');

class AdminModel extends DB{

    public function getCategorias($cuerpo){
        $query = "SELECT categories.Category_abbr, categories.Category_name, cuerpos.Cuerpo_name, cuerpos.Cuerpo_abbr
                  FROM categories
                  JOIN cuerpos ON categories.Cuerpo = cuerpos.Cuerpo_abbr
                  WHERE cuerpos.Cuerpo_abbr = '$cuerpo'";
        return $this->run_query($query);
    }

    public function getCuerpos($cuerpo){

        $query = "SELECT * FROM cuerpos
                  WHERE `Cuerpo_abbr` = '$cuerpo'";
        return $this->run_query($query);
    }

    public function InsertFile($values){

        $query = "INSERT 
        INTO documentos (Document_title, Cuerpo_abbr, Category_abbr, Certification_number, Fiscal_year, Document_lenguaje, Document_path, Date_created, Document_state, Amended) 
        VALUES ('" . $values['file_name'] . "', '" . $values['file_corp'] . "', '" . $values['file_cat'] . "', '" . $values['file_number'] . "', '" . $values['file_year'] . "', '" . $values['file_lang'] . "', '" . $values['file_path'] . "', '" . $values['file_date'] . "', '" . $values['file_state'] . "', 0)";
        return $this->run_query($query);
    }

    public function GetEnlazarDocumentos($cuerpo){

        $query = "SELECT documentos.Certification_number, documentos.Fiscal_year, documentos.Document_title, categories.Category_name
        FROM documentos
        JOIN categories ON categories.Category_abbr = documentos.Category_abbr
        WHERE documentos.Cuerpo_abbr = '$cuerpo'";
        return $this->run_query($query);
    }
 
    public function getEditDocumentos($cuerpo){
        
        $query = "SELECT Document_title, Date_created,Document_id,Fiscal_year,Cuerpo_abbr,Certification_number,Document_path,Document_state,Document_lenguaje FROM documentos
                  WHERE Cuerpo_abbr = '$cuerpo'";
        return $this ->run_query($query);
    }

    public function  search_queryn($searchQuery){
        
        $query = "SELECT Document_title, Date_created,Document_id,Fiscal_year,Cuerpo_abbr,Certification_number,Document_path,Document_state,Document_lenguaje FROM documentos WHERE Document_title LIKE $searchQuery ";
        return $this ->run_query($query);
    }

    public function updateDocument($documentId, $newName, $newDate,$fiscal,$cuerpo,$certi,$path,$estado,$lenguaje) {
        
        $query = "UPDATE documentos SET Document_title = '$newName', Date_created = '$newDate',Fiscal_year = '$fiscal',Cuerpo_abbr = '$cuerpo' ,Certification_number = '$certi' ,Document_path = '$path' , Document_state = '$estado' , Document_lenguaje = '$lenguaje'  WHERE Document_id = '$documentId'";
        return $this ->run_query($query);
    }

    //categorias
    public function NewCategory($categoria,$Abreviacion,$cuerpo) {
        $query = "INSERT INTO categories 
        (Category_abbr, Category_name, Cuerpo) 
        VALUES ('".$Abreviacion . "','". $categoria . "','". $cuerpo."')";
        return $this->run_query($query);
    }
    //update categoria
    public function updateCategory($categoria,$Abreviacion,$cuerpo,$oldabbr) {
        $query = "UPDATE categories SET Category_abbr = '$Abreviacion', Category_name = '$categoria', Cuerpo = '$cuerpo'
                  WHERE Category_abbr = '$oldabbr'";
        return $this->run_query($query);
    }
    //update documentos en la categoria
    public function updateACategory($Abreviacion,$oldabbr) {
        $query = "UPDATE `documentos` SET `Category_abbr` = '$Abreviacion' 
                  WHERE `Category_abbr` = '$oldabbr'";
        return $this->run_query($query);
    }

    //cuerpos
    public function NewCuerpo($cuerpo,$Abreviacion) {
        $query = "INSERT INTO cuerpos (Cuerpo_abbr, Cuerpo_name) 
        VALUES ('".$Abreviacion . "','". $cuerpo ."')";
        return $this->run_query($query);

    }
    //update el cuerpo
    public function updateCuerpo($cuerpo, $Abreviacion,$oldabbr) {
        $query = "UPDATE cuerpos SET Cuerpo_abbr = '$Abreviacion', Cuerpo_name = '$cuerpo' 
                  WHERE Cuerpo_abbr = '$oldabbr'";
        return $this->run_query($query);
    }
    //Update categorias en el cuerpo
    public function updateACuerpo($Abreviacion, $oldabbr){
        $query = "UPDATE `categories` SET `Cuerpo` = '$Abreviacion' 
        WHERE `Cuerpo` = '$oldabbr'";
        return $this->run_query($query);
    }
    //Update documentos en el cuerpo
    public function updateBdocs($Abreviacion, $oldabbr){
        $query = "UPDATE `documentos` SET `Cuerpo_abbr` = '$Abreviacion'
        WHERE `Cuerpo_abbr` = '$oldabbr'";
        return $this->run_query($query);
    }
    //Update cuerpo en la session del admin
    public function updateCdocs($Abreviacion, $oldabbr){
        $query = "UPDATE `admin` SET `Cuerpo` = '$Abreviacion' 
        WHERE `Cuerpo` = '$oldabbr'";
        return $this->run_query($query);
    }

    //contains 
    public function Tracking($admin,$document,$action){
        $query = "INSERT INTO `tracking` (`Admin_id`, `Document_id`, `Action`, `Date`) 
                  VALUES ('$admin', '$document', '$action', current_timestamp())";
        return $this->run_query($query);
    }

}
?>