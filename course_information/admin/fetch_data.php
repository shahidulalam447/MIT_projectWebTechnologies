<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'db_course_info');   

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define records per page
$records_per_page = 1;

// Determine the table type and current page from the AJAX request
$table_type = isset($_GET['table_type']) ? $_GET['table_type'] : 'course_summary';
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Initialize variables
$sql = "";
$total_records = 0;
$data_html = "";

// Fetch data based on table type
switch ($table_type) {
    case 'course_summary':
        $sql = "SELECT COUNT(*) AS total FROM course_summary";
        $result = mysqli_query($conn, $sql);
        $total_records = mysqli_fetch_assoc($result)['total'];

        $sql = "SELECT * FROM course_summary LIMIT $offset, $records_per_page";
        $query = mysqli_query($conn, $sql);

        $data_html .= "<table class='table table-success'>
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

            $data_html .= "<tr>
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
        $data_html .= "</table>";
        break;

    case 'courses':
        $sql = "SELECT COUNT(*) AS total FROM courses";
        $result = mysqli_query($conn, $sql);
        $total_records = mysqli_fetch_assoc($result)['total'];

        $sql = "SELECT * FROM courses LIMIT $offset, $records_per_page";
        $query = mysqli_query($conn, $sql);

        $data_html .= "<table class='table table-success'>
                        <tr>
                            <th>Course Id</th>
                            <th>Course Code</th>
                            <th>Course Title</th>
                            <th>Total Semester</th>
                            <th>Faculty Id</th>
                            <th>Action</th>
                        </tr>";
        while ($data = mysqli_fetch_assoc($query)) {
            $cid = $data['cid'];
            $course_code = $data['course_code'];
            $course_title = $data['course_title'];
            $credit = $data['credit'];
            $teacher_id = $data['teacher_id'];

            $data_html .= "<tr>
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
        $data_html .= "</table>";
        break;

    case 'faculties':
        $sql = "SELECT COUNT(*) AS total FROM faculties";
        $result = mysqli_query($conn, $sql);
        $total_records = mysqli_fetch_assoc($result)['total'];

        $sql = "SELECT * FROM faculties LIMIT $offset, $records_per_page";
        $query = mysqli_query($conn, $sql);

        $data_html .= "<table class='table table-success'>
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

            $data_html .= "<tr>
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
        $data_html .= "</table>";
        break;
}

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Create pagination controls
$prev_page = $current_page > 1 ? $current_page - 1 : 1;
$next_page = $current_page < $total_pages ? $current_page + 1 : $total_pages;
$pagination_html = "
    <div class='pagination-controls'>
        <a href='javascript:void(0);' onclick='loadData(\"$table_type\", $prev_page)' class='btn btn-secondary'>Previous</a>
        <a href='javascript:void(0);' onclick='loadData(\"$table_type\", $next_page)' class='btn btn-secondary'>Next</a>
    </div> <br>";

echo json_encode(['data' => $data_html, 'pagination' => $pagination_html]);

mysqli_close($conn);
?>
