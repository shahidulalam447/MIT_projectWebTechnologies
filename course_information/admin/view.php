<?php 
// For page secure  start
session_start();
if(!empty($_SESSION['user_id'])){

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'db_course_info');   

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Function to execute deletion with error handling
function executeDeletion($conn, $sql, $param) {
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $param);
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
        return false;
    }
}

// Delete Course Summary
if (isset($_GET['deleteid1'])) {
    $deleteid1 = $_GET['deleteid1'];
    $sql = "DELETE FROM course_summary WHERE csid = ?";
    if (executeDeletion($conn, $sql, $deleteid1)) {
        header('Location:view.php');
        exit;
    }
}

// Delete Course Information
if (isset($_GET['deleteid2'])) {
    $deleteid2 = $_GET['deleteid2'];
    $sql = "DELETE FROM courses WHERE cid = ?";
    if (executeDeletion($conn, $sql, $deleteid2)) {
        header('Location:view.php');
        exit;
    }
}

// Delete Faculty Information
if (isset($_GET['deleteid3'])) {
    $deleteid3 = $_GET['deleteid3'];

    // Delete related courses first
    $sql = "DELETE FROM courses WHERE teacher_id = ?";
    if (executeDeletion($conn, $sql, $deleteid3)) {
        // Now delete the faculty record
        $sql = "DELETE FROM faculties WHERE fid = ?";
        if (executeDeletion($conn, $sql, $deleteid3)) {
            header('Location:view.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View Information</title>
    <link rel="icon" sizes="48x48" href="/img/iictLogo.png">
    <!-- Bootstrap 5 CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-6 pt-4 mt-4">
            <a class="m-1 btn btn-sm btn-success d-flex" href="../">Go to home</a>
            <a class="m-1 btn btn-sm btn-success" href="logout.php">Log Out</a>
        </div>
        <div class="col-sm-6 pt-4 mt-4">
            <a class="m-1 btn btn-sm btn-success d-flex justify-content-end" href="index.php">Add Information</a>
        </div>        
    </div>
</div>
<div class="container">
    <!-- Course Summary Section -->
    <section>
        <div class="row">
            <div class="col-sm-12 pt-4 mt-4">
                <h3 class="text-center pb-3 pt-3 bg-success text-white">Course Summary Information</h3>
                <?php
                $sql = "SELECT * FROM course_summary";
                $query = mysqli_query($conn, $sql);

                echo "<table class='table table-success'>
                        <tr>
                            <th>Course Summary Id</th>
                            <th>Total Credit</th>
                            <th>Course Length</th>
                            <th>Total Semester</th>
                            <th>Action</th>
                        </tr>";
                while ($data = mysqli_fetch_assoc($query)) {
                    $csid = $data['csid'];
                    $total_credit = $data['total_credit'];
                    $course_length = $data['course_length'];
                    $total_semester = $data['total_semester'];

                    echo "<tr>
                            <td>$csid</td>
                            <td>$total_credit</td>
                            <td>$course_length</td>
                            <td>$total_semester</td>
                            <td>
                                <span class='btn btn-success'>
                                <a href='edit.php?csid=$csid' class='text-white text-decoration-none'>Edit</a>
                                </span>
                                <span class='btn btn-danger'>
                                <a href='view.php?deleteid1=$csid' class='text-white text-decoration-none'>Delete</a>
                                </span>
                            </td>
                          </tr>";
                }
                echo "</table>";
                ?>
            </div>
        </div>
    </section>

    <!-- Course Information Section -->
    <section>
        <div class="row">
            <div class="col-sm-12 pt-4 mt-4">
                <h3 class="text-center pb-3 pt-3 bg-success text-white">Course Information</h3>
                <?php
                $sql = "SELECT * FROM courses";
                $query = mysqli_query($conn, $sql);

                echo "<table class='table table-success'>
                        <tr>
                            <th>Course Id</th>
                            <th>Course Code</th>
                            <th>Course Title</th>
                            <th>Total Semester</th>
                            <th>Teacher Assign</th>
                            <th>Action</th>
                        </tr>";
                while ($data = mysqli_fetch_assoc($query)) {
                    $cid = $data['cid'];
                    $course_code = $data['course_code'];
                    $course_title = $data['course_title'];
                    $credit = $data['credit'];
                    $teacher_id = $data['teacher_id'];

                    echo "<tr>
                            <td>$cid</td>
                            <td>$course_code</td>
                            <td>$course_title</td>
                            <td>$credit</td>
                            <td>$teacher_id</td>
                            <td>
                                <span class='btn btn-success'>
                                <a href='edit.php?cid=$cid' class='text-white text-decoration-none'>Edit</a>
                                </span>
                                <span class='btn btn-danger'>
                                <a href='view.php?deleteid2=$cid' class='text-white text-decoration-none'>Delete</a>
                                </span>
                            </td>
                          </tr>";
                }
                echo "</table>";
                ?>
            </div>
        </div>
    </section>

    <!-- Faculty Information Section -->
    <section>
        <div class="row">
            <div class="col-sm-12 pt-4 mt-4">
                <h3 class="text-center pb-3 pt-3 bg-success text-white">Faculty Information</h3>
                <?php
                $sql = "SELECT * FROM faculties";
                $query = mysqli_query($conn, $sql);

                echo "<table class='table table-success'>
                        <tr>
                            <th>Faculty Id</th>
                            <th>Teacher Name</th>
                            <th>Designation</th>
                            <th>Action</th>
                        </tr>";
                while ($data = mysqli_fetch_assoc($query)) {
                    $fid = $data['fid'];
                    $teacher_name = $data['teacher_name'];
                    $designation = $data['designation'];

                    echo "<tr>
                            <td>$fid</td>
                            <td>$teacher_name</td>
                            <td>$designation</td>
                            <td>
                                <span class='btn btn-success'>
                                <a href='edit.php?fid=$fid' class='text-white text-decoration-none'>Edit</a>
                                </span>
                                <span class='btn btn-danger'>
                                <a href='view.php?deleteid3=$fid' class='text-white text-decoration-none'>Delete</a>
                                </span>
                            </td>
                          </tr>";
                }
                echo "</table>";
                ?>
            </div>
        </div>
    </section>
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

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
<?php 
// For page secure  end
}
else{
    header('location: login.php');
}
?>
