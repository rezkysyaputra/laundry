<?php
include "../includes/db_connect.php";

session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
  header('Location: ../index.php');
  exit();
}

if (isset($_POST["submit"])) {
  $id = 1;
  $name = $_POST['name'];
  $vision = $_POST['vision'];
  $mission = $_POST['mission'];
  $phone_number = $_POST['phone_number'];
  $email = $_POST['email'];
  $city = $_POST['city'];
  $district = $_POST['district'];
  $postal_code = $_POST['postal_code'];
  $street = $_POST['street'];
  $url_map = $_POST['url_map'];
  $about = $_POST['about'];

  // Handle file upload
  $upload_dir = '../uploads/';
  $banner_path = '';
  $about_img_path = '';

  if (isset($_FILES['banner']) && $_FILES['banner']['error'] == 0) {
    $banner_path = $upload_dir . basename($_FILES['banner']['name']);
    move_uploaded_file($_FILES['banner']['tmp_name'], $banner_path);
  }

  if (isset($_FILES['about_img']) && $_FILES['about_img']['error'] == 0) {
    $about_img_path = $upload_dir . basename($_FILES['about_img']['name']);
    move_uploaded_file($_FILES['about_img']['tmp_name'], $about_img_path);
  }

  // Update database
  $sql = "UPDATE profil_company SET 
        name_company = '$name', 
        vision = '$vision', 
        mission = '$mission', 
        phone_number = '$phone_number', 
        email = '$email', 
        city = '$city', 
        district = '$district', 
        postal_code = '$postal_code', 
        street = '$street', 
        url_map = '$url_map', 
        about = '$about'";

  // Append file columns if they exist
  if (!empty($banner_path)) {
    $sql .= ", banner_img = '$banner_path'";
  }
  if (!empty($about_img_path)) {
    $sql .= ", about_img = '$about_img_path'";
  }

  $sql .= " WHERE id = $id";

  if ($db->query($sql) === TRUE) {
    header("Location: ../admin/profil.php?status=success");
  } else {
    header("Location: ../admin/profil.php?status=failed");
  }
}

$db->close();
