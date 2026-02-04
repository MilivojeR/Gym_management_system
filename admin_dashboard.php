<?php
require_once 'config.php';

if(!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
} 
echo "Welcome to the Admin Dashboard!";


?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel=stylesheet href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css">
</head>
<body>

<div class="container">
    <div class="row -mb-5">
        <div class="col-md-6">
            <H2>Register Member</H2>
            <form action="register_member.php" method="POST" enctype="multipart/form-data">
                First Name: <input class="form-control" type = "text" name="first_name" required><br>
                Last Name: <input class="form-control" type = "text" name="last_name" required><br>
                Email: <input class="form-control" type = "email" name="email" required><br>
                Phone Number: <input class="form-control" type = "text" name="phone" required><br>
                Training Plan:
                <select class="form-control" name="training_plan_id" required>
                    <option value="" disabled selected>Training Plan</option>
                    <option value="1"> 12 sessions plan</option>
                    <option value="2"> 30 sessions plan</option>
                </select><br>
                <input type="hidden" name="photo_path" id="photoPathInput">
                <div id="dropzone-upload" class="dropzone"></div>

                <input class="btn btn-primary" type="submit" value="Register Member">
            </form>
         </div>
     </div>
</div>

</body>
</html>