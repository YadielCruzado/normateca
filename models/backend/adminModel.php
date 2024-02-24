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
        $query = "SELECT Document_title, Date_created,Document_id FROM documentos ";
        return $this ->run_query($query);
    }

    public function updateDocument($documentId, $newName, $newDate) {
        $query = "UPDATE documentos SET Document_title = $newName, Date_created = $newDate WHERE Document_id = $documentId";
        return $this ->run_query($query);

    }
    // public function updateDocument($documentId, $newName, $newDate) {
    //     $query = "UPDATE documentos SET Document_title = ?, Date_created = ? WHERE Document_id = ?";
    //     $stmt = $this->connection->prepare($query);
    //     $stmt->bind_param("sii", $newName, $newDate, $documentId);
    
    //     if ($stmt->execute()) {
    //         return true; // Update successful
    //     } else {
    //         // Log or handle the error
    //         echo "Error: " . $this->connection->error;
    //         return false; // Update failed
    //     }
    // }
    
    

}