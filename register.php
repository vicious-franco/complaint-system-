<?php
session_start();
include "database/config.php";

// If user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";

// When user clicks register button
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if all fields are filled
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Please fill in all fields";
    } 
    // Check if passwords match
    else if ($password != $confirm_password) {
        $error = "Passwords do not match!";
    }
    // Check if password is at least 6 characters
    else if (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    }
    else {
        // Check if email already exists
        $check = $conn->query("SELECT * FROM users WHERE email='$email'");
        
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered!";
        } else {
            // Encrypt password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user into database
            $insert = $conn->query("INSERT INTO users(name, email, password) VALUES('$name', '$email', '$hashed_password')");
            
            if ($insert) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Customer Complaints System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-400 to-purple-700 min-h-screen flex items-center justify-center p-5">
    <div class="bg-white/95 backdrop-blur-2xl rounded-3xl p-8 md:p-12 shadow-2xl border border-white/50 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Create Account</h1>
            <p class="text-gray-600">Join us today!</p>
        </div>

        <?php if ($error != "") { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <?php if ($success != "") { ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
                <?php echo $success; ?>
            </div>
        <?php } ?>

        <form method="post" class="space-y-6">
            <div>
                <label class="block mb-2 text-gray-700 font-semibold">Full Name</label>
                <input type="text" name="name" placeholder="Enter your full name" required 
                       class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
            </div>

            <div>
                <label class="block mb-2 text-gray-700 font-semibold">Email Address</label>
                <input type="email" name="email" placeholder="your.email@example.com" required 
                       class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
            </div>

            <div>
                <label class="block mb-2 text-gray-700 font-semibold">Password</label>
                <input type="password" name="password" placeholder="At least 6 characters" required 
                       class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
            </div>

            <div>
                <label class="block mb-2 text-gray-700 font-semibold">Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Re-enter your password" required 
                       class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
            </div>

            <button type="submit" name="register" 
                    class="w-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white px-8 py-4 rounded-full font-semibold text-lg shadow-lg transition-all hover:-translate-y-1 hover:shadow-2xl">
                Register
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-gray-600">Already have an account? 
                <a href="login.php" class="text-indigo-600 font-semibold hover:underline">Login here</a>
            </p>
        </div>
    </div>
</body>
</html>