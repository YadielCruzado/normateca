<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/normateca/models/backend/loginModel.php');


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $model = new LoginModel("localhost", "normateca", "root", "");
        $model->start_connection();
        $result = $model->LoginUser($email, $password);
        $model->connection->close();

        if ($result->num_rows > 0) {
            echo "hola";
            while ($row = $result->fetch_assoc()) {
                echo $row['name'];
                echo $row['Last_name'];
                echo $row['Cuerpo'];
            }
        }
    }
}
?>