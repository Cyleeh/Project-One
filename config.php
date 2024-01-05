<?php 

// DB credentials

    DEFINE('HOST', 'localhost');
    DEFINE('USERNAME', 'root');
    DEFINE('PASSWORD', '');
    DEFINE('DATABASE', 'projectone');

    //dsn set up

    $dsn = 'mysql:host='.HOST . ';dbname=' .DATABASE;

    try {
        $con = new PDO($dsn, USERNAME, PASSWORD);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //fetch object
        $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //for limits

        } catch (PDOException $e) {
            echo 'Connection Failed: ' . $e->getMessage();
        }

    //delete function

    if(isset($_GET['delete'])) {
        $id = $_GET['userId'];

        $sql = "DELETE FROM users WHERE id=:id";

        $delete = $con->prepare($sql);
        $delete -> bindParam(':id',$id,PDO::PARAM_INT);
        $delete->execute();

        header("Location:index.php");
    }
?>