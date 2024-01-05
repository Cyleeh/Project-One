<?php

include('config.php');

//for adding function
if(isset($_POST['add']))
{
    $FName=$_POST['FName'];
    $LName=$_POST['LName'];
    $UAge=$_POST['UAge'];

    $sql="INSERT INTO users(FName, LName, UAge) VALUE(:FName, :LName, :UAge)";

    $query=$con->prepare($sql);
    $query->execute
    ([
        'FName' => $FName,
        'LName' => $LName,
        'UAge'  => $UAge
    ]);

    $lastinsertedid = $con->lastInsertId();
        if ($lastinsertedid) {
            header("Location: index.php");
        }else{
            header("Location: index.php?err='incomplete'");
        }
}

//for editing function
if (isset($_POST['Update']))    {
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userAge = $_POST['userAge'];

    $sql = "UPDATE users SET FName=:firstName, LName=:lastName, UAge=:userAge 
    WHERE id=:id";

    $update=$con->prepare($sql);
    $run=$update->execute([
        'id' => $id,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'userAge'  => $userAge
    ]);

    if($run){
        header("location: index.php");
    }else{
        header("location: index.php?error");
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>ProjectOne</title>
<style> 
    .myHome {
        margin: 10%;
        border: 1px;
        text-align: left;
    }

    .title{
        padding-top: 5%;
        text-align: center;
        color:black;
    }
    body{
        background-color: whitesmoke;
    }
    .table{
        margin: 10%;
        width: 80%;
        border-style: solid;
        padding:1%;
    }
    .insert{
        padding-bottom: 20px;
        padding-left: 8%;
        margin: 10%;
        width: 80%;
        border-style: solid;
        text-align: left;
    }
    .viewing{
        margin: 10%;
        border-style: solid;
        width: 80%;
        text-align: left;
        padding-bottom: 5%;
        padding-top: 3%;
        padding-left: 8%;
    }
    .update{
        padding-top: 5%;
        border-color: grey;
        padding-bottom: 20px;
        padding-left: 8%;
        margin: 10%;
        width: 80%;
        border-style: solid;
    }
    .inputs{
        margin: 10%;
    }
    .inputTwo{
        padding-top: 4%;
        padding-left: 1%;
    }
    .uLabel{
        padding-bottom: 2%;
    }
    .updateBtn{
        padding-top: 1%;
        padding-left: 12%;
    }
    .btnTwo{
        padding-top: 1%;
        padding-left: 12%;
    }



</style>
</head>
<body>
    <div class="title">
    <h1>PROJECT ONE</h1>
    </div>
<hr>
<div class="myHome mt-3">
    <a href="index.php">Home</a>
</div>

<?php
    if (isset($_GET['update'])) {
        //updating data
        $id=$_GET['userId'];

        $get_id=$con->prepare("SELECT * FROM users WHERE id=:id");
        $get_id->setFetchMode(PDO:: FETCH_ASSOC);
        $get_id->execute(['id'=> $id]);

        while ($row=$get_id->fetch()){
            
        $id=$row['id'];
        $FName=$row['FName'];
        $LName=$row['LName'];
        $UAge=$row['UAge'];
    
        echo"
        <div class='update'>
        <div class='uLabel'><h3>EDIT INFO<h3></div>
        
        <form method='POST' action='index.php'>
        <input type='hidden' name='id' value='$id'>
        <label>First Name :</label> <input type='text' name='firstName' value='$FName' ><br>
        <label>Last Name :</label> <input type='text' name='lastName' value='$LName'><br>
        <label>Age :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label> <input type='number' name='userAge' value='$UAge'><br>
        <div class='updateBtn'> <button name='Update'>&nbsp&nbsp&nbspUPDATE&nbsp&nbsp&nbsp&nbsp</button> </div>
        </form>
        
        </div>
        ";
        }
    }elseif (isset($_GET['view'])) {
        $id=$_GET['view'];

        $get_id=$con->prepare("SELECT * FROM users WHERE id=:id");
        $get_id->setFetchMode(PDO:: FETCH_ASSOC);
        $get_id->execute(['id'=> $id]);

     while ($row=$get_id->fetch()){
            
            $id=$row['id'];
            $FName=$row['FName'];
            $LName=$row['LName'];
            $UAge=$row['UAge'];

        echo "<div class='viewing'>
             <h3>VIEWING INFORMATION</h3>
             <label>First Name: $FName</label><br>
             <label>Last Name: $LName</label><br>
             <label>Age: $UAge</label>
             </div>
        ";}    
    }else{
        //<!--Inserting Data -->
        echo "
        <div class='insert'>
        <div class='inputTwo'> <h3>Create Data</h3> </div>
        
        <form method='POST' action='index.php'>
        <label>First Name :</label> <input type='text' name='FName'><br>
        <label>Last Name :</label> <input type='text' name='LName'><br>
        <label>Age:  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label> <input type='number' name='UAge'><br>
        <div class='btnTwo'><button name='add'>&nbsp&nbsp&nbspSUBMIT&nbsp&nbsp&nbsp&nbsp</button></div>
        </form>

        </div>
    ";



    }

?>


<div class="table">
<table class="table table-hover">
    <thead>
        <div class=inputs>
            <h3>INFORMATION</h3>
        </div>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age </th>
            <th colspan="3">Action</th>
        </tr>
    </thead>

<?php

//getting data to users table
$get_user=$con->prepare("SELECT * FROM users");
$get_user->setFetchMode(PDO:: FETCH_ASSOC);
$get_user->execute();

while ($row=$get_user->fetch()) {




?>
    <tbody>
        <tr>
            <td><?= $row['FName'] ?></td>
            <td><?= $row['LName'] ?></td>
            <td><?= $row['UAge'] ?></td>
            <td><a href="?update&&userId=<?= $row['id'] ?>">Update</a></td>
            <td><a href="config.php?delete&&userId=<?= $row['id'] ?>">Delete</a></td>
            <td><a href="?view&&view=<?= $row['id'] ?>">View Info</a></td>
        </tr>
    </tbody>
    <?php } ?>
</table>
</div>
</body>
</html>