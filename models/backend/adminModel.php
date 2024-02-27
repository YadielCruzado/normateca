<?php
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/db/db_info.php');
class AdminModel extends DB{

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

    public function getDocuments1(){

        $query = "SELECT documentos.Certification_number, documentos.Fiscal_year, categories.Category_name
        FROM documentos
        JOIN categories ON categories.Category_abbr = documentos.Category_abbr";
        return $this->run_query($query);
    }


    public function  getdocinfo(){
        
        $query = "SELECT Document_title, Date_created,Document_id FROM documentos ";
        return $this ->run_query($query);
    }

    public function updateDocument($documentId, $newName, $newDate) {
        echo $documentId;
        echo $newName;
        echo $newDate;
        echo"AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
        $query = "UPDATE documentos SET Document_title = '$newName', Date_created = '$newDate' WHERE Document_id = '$documentId'";
        return $this ->run_query($query);

    }

    // public function updateDocument($documentId, $newName, $newDate) {
    //     $query = "UPDATE documentos SET Document_title = ?, Date_created = ? WHERE Document_id = $documentId";
    //     $stmt = $this->connection->prepare($query);
    //     $stmt->bind_param('ss', $newName, $newDate, $documentId);
    

        
    //     if ($stmt->execute()) {
    //         return true; // Update successful
    //     } else {
    //         // Log or handle the error
    //         echo "Error: " . $this->connection->error;
    //         return false; // Update failed
    //     }
    // }
    
    

}
