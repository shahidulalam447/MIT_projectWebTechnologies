<?php 
// For page secure  start
session_start();
if(!empty($_SESSION['user_id'])){


// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'db_course_info');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Course Summary
if (isset($_POST['submit_course_summary'])) {
    $csid = $_POST['csid'];
    $total_credit = $_POST['total_credit'];
    $course_length = $_POST['course_length'];
    $total_semester = $_POST['total_semester'];

    $sql = "INSERT INTO course_summary (csid, total_credit, course_length, total_semester) VALUES ('$csid', '$total_credit', '$course_length', '$total_semester')";

    if (mysqli_query($conn, $sql)) {
        echo "Course Summary Data Inserted";
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Course Information
if (isset($_POST['submit_course_info'])) {
    $cid = $_POST['cid'];
    $course_code = $_POST['course_code'];
    $course_title = $_POST['course_title'];
    $credit = $_POST['credit'];
    $teacher_id = $_POST['teacher_id'];

    $sql = "INSERT INTO courses (cid, course_code, course_title, credit, teacher_id) VALUES ('$cid', '$course_code', '$course_title', '$credit', '$teacher_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Course Information Data Inserted";
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Faculty Information
if (isset($_POST['submit_faculty_info'])) {
    $fid = $_POST['fid'];
    $teacher_name = $_POST['teacher_name'];
    $designation = $_POST['designation'];

    $sql = "INSERT INTO faculties (fid, teacher_name, designation) VALUES ('$fid', '$teacher_name', '$designation')";

    if (mysqli_query($conn, $sql)) {
        echo "Faculty Information Data Inserted";
        header('Location: index.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Information</title>
    <link rel="icon" sizes="48x48" href="/img/iictLogo.png">
    <!-- Bootstrap 5 CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <h2 class="mt-4 pb-2 text-center bg-success text-white">Insert Form</h2>
        <!-- Course Summary  -->
        <div class="col-sm-4 p-2 mt-4 border border-success">
            <h5>Course Summary</h5> <hr>
            <form action="index.php" method="POST">
                Course Summary Id: <br>
                <input type="number" name="csid" required><br>
                Total Credit: <br>
                <input type="number" name="total_credit" required><br>
                Course Length: <br>
                <input type="text" name="course_length" required><br>
                Total Semester: <br>
                <input type="number" name="total_semester" required><br><br><br><br>
                <input type="submit" value="Insert" name="submit_course_summary" class="btn btn-success mt-1">
            </form>
        </div>

        <!-- Course Information  -->
        <div class="col-sm-4 p-2 mt-4 border border-success">
            <h5>Course Information</h5><hr>
            <form action="index.php" method="POST">
                Course Id: <br>
                <input type="number" name="cid" required><br>
                Course Code: <br>
                <input type="text" name="course_code" required><br>
                Course Title : <br>
                <input type="text" name="course_title" required><br>
                Credit: <br>
                <input type="number" name="credit" required><br>
                Teacher Assign: <br>
                <input type="number" name="teacher_id" required><br><br>
                <input type="submit" value="Insert" name="submit_course_info" class="btn btn-success">
            </form>
        </div>

        <!-- Faculty Information  -->
        <div class="col-sm-4 p-2 mt-4 border border-success">
            <h5>Faculty Information</h5><hr>
            <form action="index.php" method="POST">
                Faculty Id: <br>
                <input type="number" name="fid" required><br>
                Teacher Name : <br>
                <input type="text" name="teacher_name" required><br>
                Designation: <br>
                <input type="text" name="designation" required><br><br><br><br><br><br>
                <input type="submit" value="Insert" name="submit_faculty_info" class="btn btn-success mt-2">
            </form>
        </div>
        <a class="mt-1 h5 btn btn-sm btn-success" href="view.php">Admin View</a>
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
// For page secure  end
}
else{
    header('location: login.php');
}
?>
