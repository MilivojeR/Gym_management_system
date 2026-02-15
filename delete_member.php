<?php
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $sql = 'DELETE FROM members WHERE member_id=?';
    $run = $conn->prepare($sql);
    $run->bind_param("i", $member_id);
    $message = "";
    if($run->execute()) {
        $message = "Challanger left the arena. Member deleted successfully.";
    } else {
        $message = "Power level too strong, can not delete member.";
    }
    $_SESSION['success_message'] = $message;   
    header("Location: admin_dashboard.php");
    exit();


}