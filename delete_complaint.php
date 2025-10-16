<?php
include "database/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $delete = $conn->query("DELETE FROM complaints WHERE id='$id'");
    
    if ($delete) {
        echo "<script>alert('Complaint deleted successfully'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error deleting complaint'); window.location.href='index.php';</script>";
    }
} else {
    header("Location: index.php");
}
?>