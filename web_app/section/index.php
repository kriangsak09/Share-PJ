<?php
session_start(); // เริ่มต้น session
include('db.php');

// ดึงข้อมูลวิชาจากฐานข้อมูล
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject List</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* การตั้งค่าคอนเทนเนอร์หลัก */
        .container {
            padding: 30px;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Page content wrapper-->
        <div class="page-content-wrapper">

            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item active"><a class="nav-link" href="../course-app/add.php">Add New Course</a></li>
                            <li class="nav-item active"><a class="nav-link" href="../add-teachers/index.php">Add Teacher</a></li>
                            <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Top navigation-->
            <br>

            <!-- Page content-->
            <div class="container mt-5">
            <h1 class="mb-4">Subject List</h1>
            <!-- เพิ่มฟอร์มสำหรับค้นหา -->
            <form action="../searchgroup.php" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Course" name="search">
                     <!-- <button type="submit" class="btn btn-outline-secondary">Search</button> -->
                </div>
            </form>

                <ul class="list-group">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                <div>
                                    <h5 class='mb-0'><strong>Subject Name:</strong> " . $row["subject_name"] . "</h5>
                                    <h5 class='mb-0'><strong>Subject ID:</strong> " . $row["subject_id"] . "</h5>
                                    <p class='mb-0'><strong>Course Name:</strong> " . $row["course_name"] . "</p>
                                    <p class='mb-0'><strong>Theory Hours:</strong> " . $row["theory_hours"] . "</p>
                                    <p class='mb-0'><strong>Practical Hours:</strong> " . $row["practical_hours"] . "</p>
                                    <p class='mb-0'><strong>Semester:</strong> " . $row["semester"] . "</p>
                                    <p class='mb-0'><strong>Academic Year:</strong> " . $row["academic_year"] . "</p>
                                    <p class='mb-0'><strong>Day of Week:</strong> " . $row["day_of_week"] . "</p>
                                    <p class='mb-0'><strong>Start Time:</strong> " . $row["start_time"] . "</p>
                                    <p class='mb-0'><strong>End Time:</strong> " . $row["end_time"] . "</p>
                                    <p class='mb-0'><strong>Section:</strong> " . $row["section"] . "</p>
                                </div>
                                <div>";
                                
                            // ส่ง subject_id ผ่าน URL
                            echo "<a href='./import-students/manage-members.php?subject_id=" . $row['subject_id'] . "' class='btn btn-info btn-sm'>Create Section</a>";
                            echo "</div></li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>0 results</li>";
                    }
                    ?>
                </ul>
            </div>
        <!-- End Page content-->
        </div>
    <!-- End Page content wrapper-->
    </div>
</body>
</html>

<?php
$conn->close();
?>
