<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/models/backend/loginModel.php');

function setLogin(){
    $model = new LoginModel("localhost", "normateca", "root", "");
    $model->start_connection();
    $cuerpos = [];

    $result = $model->getCuerpos();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values = array(
                "corp_abbr" => $row['Cuerpo_abbr'],
                "corp_name" => $row['Cuerpo_name']
            );

            array_push($cuerpos, $values);
        }
    }else {
        $cuerpos = null;
    }

    $_SESSION['cuerpos'] = $cuerpos;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['email']) && isset($_POST['password'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];
        $cuerpo = $_POST['cuerpo'];

        $model = new LoginModel("localhost", "normateca", "root", "");
        $model->start_connection();
        $result = $model->LoginUser($email, $password);
        $model->connection->close();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if($cuerpo == $row['Cuerpo']){
                    if (!isset($_SESSION['login'])) {
                        $_SESSION['login'] = [];
                    }

                    $_SESSION['login'] = [
                        "ID" => $row['Admin_id'],
                        "Nombre" => $row['name'],
                        "Apellido" => $row['Last_name'],
                        "Cuerpo" => $row['Cuerpo']
                    ];
                    
                    header("Location: ../../views/admin.php?success"); 
                } else{
                    header("Location:../../views/login.php?error");
                    $message = "Dont got acces to those documents";
                }
            }
        } else {
            header("Location: ../../views/login.php?error");
            $message = "Wrong credentials";
        }
    }
}
?>