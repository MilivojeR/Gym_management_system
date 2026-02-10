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
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

</head>
<body>
    <?php
    if(isset($_SESSION['success_message'])) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <?php endif; ?>
    <div class ="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Members List</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Trainer</th>
                            <th>Photo</th>
                            <th>Training Plan</th>
                            <th>Access Card</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbdody>
                        <?php
                        $sql="SELECT * from members";
                        $results = $conn->query($sql);
                        $results = $results->fetch_all(MYSQLI_ASSOC);

                        foreach($results as $result) : ?>
                        <tr>
                            <td><?php echo $result['first_name']; ?></td>
                            <td><?php echo $result['last_name']; ?></td>
                            <td><?php echo $result['email']; ?></td>
                            <td><?php echo $result['phone_number']; ?></td>
                            <td><?php echo $result['trainer_id']; ?></td>
                            <td><img src="<?php echo $result['photo_path']; ?>" width="100" height="100"></td>
                            <td><?php 
                            
                            $plan_id=$result['training_plan_id'];
                            $sql = "SELECT * FROM training_plans WHERE plan_id = ?";
                            $run = $conn->prepare($sql);
                            $run->bind_param("i", $plan_id);
                            $run->execute();
                            $results = $run->get_result();
                            $results = $results->fetch_assoc();
                            if($results) {
                                echo $results['name'];
                            } else {
                                echo "No training plan assigned. Skinny b****";
                            }
                            
                            ?></td>
                            <td><a href="<?php echo $result['access_card_pdf_path']; ?>" target="_blank">Access Card</a></td>
                            <td><?php
                            
                            $create_at=strtotime($result['created_at']);
                            $new_date=date("m-d-Y", $create_at);
                            echo $new_date;
                            
                            ?></td>
                            <td><button>DELETE</button></td>
                            </tr>
                        <?php endforeach; 
                        ?>
<div class="container">
    <div class="row mb-5">
        <div class="col-md-6">
            <H2>Register Member</H2>
            <form action="register_member.php" method="POST" enctype="multipart/form-data">
                First Name: <input class="form-control" type = "text" name="first_name" required><br>
                Last Name: <input class="form-control" type = "text" name="last_name" required><br>
                Email: <input class="form-control" type = "email" name="email" required><br>
                Phone Number: <input class="form-control" type = "text" name="phone_number" required><br>
                Training Plan:
                <select class="form-control" name="training_plan_id" required>
                    <option value="" disabled selected>Training Plan</option>
                    <?php
                    $sql = "SELECT * FROM training_plans";
                    $run = $conn->query($sql);
                    $results = $run->fetch_all(MYSQLI_ASSOC);

                    foreach($results as $result) {
                        echo "<option value='". $result['id'] ."'>". $result['name'] ."</option>";
                    }
                    ?>
                </select><br>

                <input type="hidden" name="photo_path" id="photoPathInput">
                <div id="dropzone-upload" class="dropzone"></div>

                <input class="btn btn-primary" type="submit" value="Register Member">
            </form>
         </div>
     </div>
</div>
<?php $conn->close(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKbdj4X9" crossorigin="anonymous"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
Dropzone.autoDiscover = false;

const dz = new Dropzone("#dropzone-upload", {
    url: "upload_photo.php",
    paramName: "photo",
    maxFiles: 1,
    maxFilesize: 30, // MB 
    acceptedFiles: "image/*",

    init: function () {
        this.on("success", function (file, response) {

            const jsonResponse = JSON.parse(response);

            if (jsonResponse.success) {
                document.getElementById("photoPathInput").value = jsonResponse.photo_path;
                console.log("Photo path saved:", jsonResponse.photo_path);
            } else {
                console.error("Upload failed:", jsonResponse.error);
            }
        });
    }
});
</script>

</body>
</html>