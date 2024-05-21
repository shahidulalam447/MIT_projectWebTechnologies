<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M1 Course Information</title>
    <link rel="icon" sizes="48x48" href="img/iictLogo.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div id="headerdiv">
        <img src="img/iictLogo.png" alt="Logo 1">
        <span id="hintro">
            <?php
                include 'db_connect.php';

                $sql = "SELECT * FROM course_summary";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "WELCOME TO MIT INFORMATION DESK <br>
                            Masters in Information Technology <br> Total Credit: " . $row["total_credit"]. " <br> Course Length: " . $row["course_length"]. " <br> Total Semester: " . $row["total_semester"]."<br>";
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
            ?>

        </span>
        <img src="img/sustLogo.png" alt="Logo 2">
        </div>
        
        <nav>
            <ul>
                <li><a href="index.php">M1</a></li>
                <li><a href="m2.php">M2</a></li>
                <li><a href="m3.php">M3</a></li>
                <!-- <li><a href="contact.php">Contact</a></li> -->
            </ul>
        </nav>
    </header>

    <main>
    <section>
        <!-- <h2>Course Information</h2> -->
        <table>
            <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Assign Teacher</th>
                <th>Credit</th>
            </tr>
            <?php
            include 'db_connect.php';

            $sql = "SELECT * FROM courses";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["course_code"]. "</td><td>" . $row["course_title"]. "</td><td>" . $row["teacher_id"]. "</td><td>" . $row["credit"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No courses available</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </section>


    <section>
    <h2>Faculty Information</h2>
    <table>
        <tr>
            <th>Assign Teacher</th>
            <th>Teacher Name</th>
            <th>Designation</th>
        </tr>
        <?php
        include 'db_connect.php';

        $sql = "SELECT * FROM faculties";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["fid"]. "</td><td>" . $row["teacher_name"]. "</td><td>" . $row["designation"]. "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No faculty available</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    </section>
    <section>
        <div class="information">
            
            <p>
                <strong>Contact Information</strong><br><br>
                IICT, SUST, Sylhet, Bangladesh <br>
                Phone: +8801977895528 <br>
                Website: iict.sust.edu   Email: iict@sust.edu
            </p>
        </div>        
        </section>

</main>

<br>
<details>
            <summary>Team Members | 6th Batch</summary>
            <p>
                Md Shahidul Alam | Reg: 2023822017 <br>
                Md Rashadul Kabir Mozumdar | Reg: 2023822016<br>
                Hafizur Rahman | Reg: 2023822012 <br><br>
                <a href="admin/login.php">Admin Panel</a>
            </p>
    </details>
    </div><br><br>

</body>
</html>
