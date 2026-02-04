<?php

require_once 'config.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {


$sql = "INSERT INTO members (
    first_name,
    last_name,
    email,
    phone_number,
    photo_path,
    training_plan_id,
    trainer_id,
    access_card_pdf_path
) VALUES (
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?'
)";

$run = $conn->prepare($sql);
$run->bind_param(
    "sssssiis",
    $_POST['first_name'],
    $_POST['last_name'],
    $_POST['email'],
    $_POST['phone'],
    $_POST['photo_path'],
    $_POST['training_plan_id'],
    null,
    null
);
}