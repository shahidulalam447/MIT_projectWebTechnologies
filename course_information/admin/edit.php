<?php 
// For page secure  start
session_start();
if(!empty($_SESSION['user_id'])){


// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'db_course_info');

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initializing variables
$csid = $total_credit = $course_length = $total_semester = "";
$cid = $course_code = $course_title = $credit = $teacher_id = "";
$fid = $teacher_name = $designation = "";

// Course Summary 
if(isset($_GET['csid'])){
    $getid = intval($_GET['csid']);
    $stmt = $conn->prepare("SELECT * FROM course_summary WHERE csid = ?");
    $stmt->bind_param("i", $getid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        $csid = $data['csid'];
        $total_credit = $data['total_credit'];
        $course_length = $data['course_length'];
        $total_semester = $data['total_semester'];
    }
}

if(isset($_POST['submit_course_summary'])){
    $csid = intval($_POST['csid']);
    $total_credit = $_POST['total_credit'];
    $course_length = $_POST['course_length'];
    $total_semester = $_POST['total_semester'];

    $stmt = $conn->prepare("UPDATE course_summary SET total_credit=?, course_length=?, total_semester=? WHERE csid=?");
    $stmt->bind_param("isii", $total_credit, $course_length, $total_semester, $csid);

    if($stmt->execute()){
        echo "Data Updated";
        header('Location: view.php');
        exit();
    } else {
        echo "Data not updated: " . $stmt->error;
    }
}

// Course Information
if(isset($_GET['cid'])){
    $getid = intval($_GET['cid']);
    $stmt = $conn->prepare("SELECT * FROM courses WHERE cid = ?");
    $stmt->bind_param("i", $getid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        $cid = $data['cid'];
        $course_code = $data['course_code'];
        $course_title = $data['course_title'];
        $credit = $data['credit'];
        $teacher_id = $data['teacher_id'];
    }
}

if(isset($_POST['submit_course_info'])){
    $cid = intval($_POST['cid']);
    $course_code = $_POST['course_code'];
    $course_title = $_POST['course_title'];
    $credit = $_POST['credit'];
    $teacher_id = $_POST['teacher_id'];

    $stmt = $conn->prepare("UPDATE courses SET course_code=?, course_title=?, credit=?, teacher_id=? WHERE cid=?");
    $stmt->bind_param("ssiii", $course_code, $course_title, $credit, $teacher_id, $cid);

    if($stmt->execute()){
        echo "Data Updated";
        header('Location: view.php');
        exit();
    } else {
        echo "Data not updated: " . $stmt->error;
    }
}

// Faculty Information
if(isset($_GET['fid'])){
    $getid = intval($_GET['fid']);
    $stmt = $conn->prepare("SELECT * FROM faculties WHERE fid = ?");
    $stmt->bind_param("i", $getid);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        $fid = $data['fid'];
        $teacher_name = $data['teacher_name'];
        $designation = $data['designation'];
    }
}

if(isset($_POST['submit_faculty_info'])){
    $fid = intval($_POST['fid']);
    $teacher_name = $_POST['teacher_name'];
    $designation = $_POST['designation'];

    $stmt = $conn->prepare("UPDATE faculties SET teacher_name=?, designation=? WHERE fid=?");
    $stmt->bind_param("ssi", $teacher_name, $designation, $fid);

    if($stmt->execute()){
        echo "Data Updated";
        header('Location: view.php');
        exit();
    } else {
        echo "Data not updated: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Information</title>
    <link rel="icon" sizes="48x48" href="/img/iictLogo.png">
    <!-- Bootstrap 5 CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
<div class="container">
    
    <!-- For edit  -->
    <div class="row">
        <h2 class="mt-4 pb-2 text-center bg-success text-white">Update Form</h2>
        <!-- Course Summary  -->
        <div class="col-sm-4 p-2 mt-4 border border-success">
            <h5>Course Summary Edit Form</h5> <hr>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                Course Summary Id: <br>
                <input type="number" name="csid" value="<?php echo htmlspecialchars($csid); ?>" required><br>
                Total Credit: <br>
                <input type="number" name="total_credit" value="<?php echo htmlspecialchars($total_credit); ?>" required><br>
                Course Length: <br>
                <input type="text" name="course_length" value="<?php echo htmlspecialchars($course_length); ?>" required><br>
                Total Semester: <br>
                <input type="number" name="total_semester" value="<?php echo htmlspecialchars($total_semester); ?>" required><br><br><br><br>
                <input type="submit" value="Update" name="submit_course_summary" class="btn btn-success mt-1">
            </form>
        </div>

        <!-- Course Information  -->
        <div class="col-sm-4 p-2 mt-4 border border-success">
            <h5>Course Information Edit Form</h5><hr>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                Course Id: <br>
                <input type="number" name="cid" value="<?php echo htmlspecialchars($cid); ?>" required><br>
                Course Code: <br>
                <input type="text" name="course_code" value="<?php echo htmlspecialchars($course_code); ?>" required><br>
                Course Title : <br>
                <input type="text" name="course_title" value="<?php echo htmlspecialchars($course_title); ?>" required><br>
                Credit: <br>
                <input type="number" name="credit" value="<?php echo htmlspecialchars($credit); ?>" required><br>
                Teacher Assign: <br>
                <input type="number" name="teacher_id" value="<?php echo htmlspecialchars($teacher_id); ?>" required><br><br>
                <input type="submit" value="Update" name="submit_course_info" class="btn btn-success">
            </form>
        </div>

        <!-- Faculty Information  -->
        <div class="col-sm-4 p-2 mt-4 border border-success">
            <h5>Faculty Information Edit Form</h5><hr>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                Faculty Id: <br>
                <input type="number" name="fid" value="<?php echo htmlspecialchars($fid); ?>" required><br>
                Teacher Name : <br>
                <input type="text" name="teacher_name" value="<?php echo htmlspecialchars($teacher_name); ?>" required><br>
                Designation: <br>
                <input type="text" name="designation" value="<?php echo htmlspecialchars($designation); ?>" required><br><br><br><br><br><br>
                <input type="submit" value="Update" name="submit_faculty_info" class="btn btn-success mt-2">
            </form>
        </div>
        <a class="mt-1 btn btn-sm btn-success" href="view.php">Admin View</a>
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