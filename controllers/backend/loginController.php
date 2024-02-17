<?php
session_start();
include_once("../../models/backend/loginModel.php");

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //if principal al hacer submit desde el login, es lo primero que verfiica el controller
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = validate($_POST["email"]); //procesa estas variables
        $pwd = validate($_POST["password"]);
        echo $email;
        echo $pwd;
        

        if (empty($email) || empty($pwd)) {
            header("Location: ../../views/login.php?error=Something is missing.");

        } else {
            $model = new LoginModel("localhost", "normateca", "root", "");
            $model->start_connection();
            $result = $model->getUser($email, $pwd);

            if ($result->num_rows == 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row["Email"] == $email && $row["Password"] == $pwd) {
                    $_SESSION["Email"] = $row["Email"];
                    $_SESSION["Password"] = $row["Password"];
                    $_SESSION["Name"] = $row["Name"];
                    $_SESSION["Last_name"] = $row["Last_name"];
                    $_SESSION["id"] = $row["Admin_id"];
                    $model->connection->close();
                    header("Location: ../../views/admin.php");
                } else {
                    $model->connection->close();
                    header("Location: ../../views/login.php?error=Credentials incorrect or doesn't exists.");
                }
            }
            $model->connection->close();
        }
    }

    if (isset($_GET["logout"])) {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../../views/login.php");
    }
} else {
    header("Location: ../../views/login.php?error=Incorrect Access.");
}