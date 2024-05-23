<?php 
// For page secure start
session_start();
if (!empty($_SESSION['user_id'])) {

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
            <div class="col-sm-12 pt-1 mt-1">
                <h3 class="text-center pb-3 pt-3 bg-success text-white">Course Summary Information</h3>
                <div id="course_summary_data"></div>
            </div>
        </div>
    </section>

    <!-- Course Information Section -->
    <section>
        <div class="row">
            <div class="col-sm-12">
                <h3 class="text-center pb-3 pt-3 bg-success text-white">Course Information</h3>
                <div id="course_information_data"></div>
            </div>
        </div>
    </section>

    <!-- Faculty Information Section -->
    <section>
        <div class="row">
            <div class="col-sm-12">
                <h3 class="text-center pb-3 pt-3 bg-success text-white">Faculty Information</h3>
                <div id="faculty_information_data"></div>
            </div>
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function loadData(table_type, page) {
    $.ajax({
        url: 'fetch_data.php',
        type: 'GET',
        data: {
            table_type: table_type,
            page: page
        },
        success: function(response) {
            const data = JSON.parse(response);
            if (table_type === 'course_summary') {
                $('#course_summary_data').html(data.data + data.pagination);
            } else if (table_type === 'courses') {
                $('#course_information_data').html(data.data + data.pagination);
            } else if (table_type === 'faculties') {
                $('#faculty_information_data').html(data.data + data.pagination);
            }
        }
    });
}

$(document).ready(function() {
    loadData('course_summary', 1);
    loadData('courses', 1);
    loadData('faculties', 1);
});
</script>
</body>
</html>

<?php
    // Close the database connection
    mysqli_close($conn);
} else {
    header('location: login.php');
}
?>
