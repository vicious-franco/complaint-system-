<!-- login.php -->
<?php
session_start();
include "database/config.php";

// If user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

// When user clicks login button
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Check if email and password are not empty
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        // Find user in database with this email
        $query = $conn->query("SELECT * FROM users WHERE email='$email'");
        
        // If user exists
        if (mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_array($query);
            
            // Check if password matches
            if (password_verify($password, $user['password'])) {
                // Login successful! Save user info in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                
                // Redirect to home page
                header("Location: index.php");
                exit();
            } else {
                $error = "Wrong password!";
            }
        } else {
            $error = "Email not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Customer Complaints System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-400 to-purple-700 min-h-screen flex items-center justify-center p-5">
    <div class="bg-white/95 backdrop-blur-2xl rounded-3xl p-8 md:p-12 shadow-2xl border border-white/50 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Welcome Back!</h1>
            <p class="text-gray-600">Login to continue</p>
        </div>

        <?php if ($error != "") { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="post" class="space-y-6">
            <div>
                <label class="block mb-2 text-gray-700 font-semibold">Email Address</label>
                <input type="email" name="email" placeholder="your.email@example.com" required 
                       class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
            </div>

            <div>
                <label class="block mb-2 text-gray-700 font-semibold">Password</label>
                <input type="password" name="password" placeholder="Enter your password" required 
                       class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
            </div>

            <button type="submit" name="login" 
                    class="w-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white px-8 py-4 rounded-full font-semibold text-lg shadow-lg transition-all hover:-translate-y-1 hover:shadow-2xl">
                Login
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-gray-600">Don't have an account? 
                <a href="register.php" class="text-indigo-600 font-semibold hover:underline">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>