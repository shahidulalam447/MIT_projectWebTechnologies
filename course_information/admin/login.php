<?php 

$conn = mysqli_connect('localhost', 'root', '', 'db_course_info');

session_start();

// if(!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

if(empty($_SESSION['user_id'])){

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($username) && !empty($password)) {
        $sql = "SELECT id FROM users WHERE username='$username' AND password='$password'";
        $sql_query = mysqli_query($conn, $sql);
        $mysqli_num_rows = mysqli_num_rows($sql_query);

        if($mysqli_num_rows) {
            
            $data = mysqli_fetch_array($sql_query);
            $id = $data['id'];

            $_SESSION['user_id']=$id;


            header('location: view.php');
        }else{
            echo 'Invlid username or password';
        }

    } else {

        echo 'Fill up all fields';
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="icon" sizes="48x48" href="/img/iictLogo.png">
    <!-- Bootstrap 5 CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
<div class="container">    
    <!-- For Login Form  -->
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6  mt-4 pb-2 text-center bg-success text-white ">
        <h2 class="mt-4 pb-2 ">Login Form</h2><hr>     
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">                
                User Name <br>
                <input type="text" name="username" required><br>
                Password <br>
                <input type="text" name="password" required><br><br><br><br>
                <input type="submit" value="Login" name="submit_login" class="btn btn-light col-sm-12">
        </form>
        <a class="h5 btn btn-sm btn-success d-flex col-sm-12" href="../">Go to home</a>
        </div>
        <div class="col-sm-3"></div>
    </div>


    <!-- <details>
            <summary>Team Members | 6th Batch</summary>
            <p>
                MD SHAHIDUL ALAM | Reg: 2023822017 <br>
                MD. Rashadul Kabir Mozumdar | Reg: 2023822016<br>
                Hafizur Rahman | Reg: <br><br>
                <a href="admin/view.php">Admin Panel</a>
            </p>
    </details> -->
</div>

</body>
</html>
<?php 
}
else{
    header('location: view.php');
}
?>
