<?php
require_once 'config.php';

echo "Welcome to the Admin Dashboard Saiyan";


if(!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();

}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" type="text/css">
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
                    <?php
                    foreach($training_plans as $plan): ?>
                    <option value="<?= $plan['plan_id'] ?>">
                        <?= $plan['plan_name'] ?>
                    </option>
                    <?php endforeach; ?>
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