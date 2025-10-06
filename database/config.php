<?php
$conn=new mysqli("localhost", "root", "", "customer_complaints");
if ($conn) {
    echo "connected";
}
?>