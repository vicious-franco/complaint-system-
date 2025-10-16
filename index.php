<?php
session_start();

// Check if user is logged in - if not, redirect to login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "database/config.php";

// Handle complaint submission
if (isset($_POST['send'])) {
   $name=$_POST['cname'];
   $email=$_POST['cemail'];
   $phone=$_POST['phone'];
   $category=$_POST['category'];
   $priority=$_POST['priority'];    
   $subject=$_POST['subject'];
   $description=$_POST['description'];
   $msg="";

   $check=$conn->query("SELECT * FROM complaints WHERE customer_email='$email'");
   if (mysqli_num_rows($check)>0) {
    echo "<script>alert('Email already in use')</script>";
   } else{
   $insert=$conn->query("INSERT INTO complaints(customer_name,customer_email ,customer_phone_number ,complaint_category, priority,subject,description)
   VALUES('$name','$email','$phone','$category','$priority','$subject','$description')");
   if ($insert) {
    echo "<script>alert('Complaint submitted successfully!')</script>";
   }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Complaints System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-400 to-purple-700 min-h-screen p-5 font-sans">
    <div class="max-w-7xl mx-auto">
        <header class="text-center mb-8 animate-fadeInDown">
            <!-- User Info and Logout Bar -->
            <div class="flex flex-col sm:flex-row justify-end items-center mb-6 gap-4 mr-10  ">
               
                <div class="bg-white/20 backdrop-blur-md rounded-full px-6 py-2 flex justify-end items-end gap-4">
                    <span class="text-white font-semibold">👤 <?php echo $_SESSION['user_name']; ?></span>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-full text-sm font-semibold transition">
                        Logout
                    </a>
                </div>
            </div>
            
            <h1 class="text-white text-4xl md:text-5xl font-bold mb-2 drop-shadow-lg">Customer Complaints System</h1>
            <p class="text-white/90 text-lg font-light">Your voice matters. We're here to help.</p>
        </header>
        
        <div class="flex flex-col md:flex-row justify-center gap-5 mb-10 animate-fadeIn">
            <button class="tab-btn px-10 py-3 rounded-full font-semibold text-lg bg-white/10 text-white border-2 border-white/20 backdrop-blur-md transition-all hover:bg-white/20 hover:-translate-y-1 shadow-lg active bg-white text-indigo-500" onclick="switchTab('submit')" id="tab-submit">Submit Complaint</button>
            <button class="tab-btn px-10 py-3 rounded-full font-semibold text-lg bg-white/10 text-white border-2 border-white/20 backdrop-blur-md transition-all hover:bg-white/20 hover:-translate-y-1 shadow-lg" onclick="switchTab('view')" id="tab-view">View All Complaints</button>
        </div>

        <!-- Submit Complaint Section -->
        <div id="submit" class="content-area block md:w-[60%] m-auto">
            <div class="bg-white/95 backdrop-blur-2xl rounded-3xl p-10 md:p-16 shadow-2xl border border-white/50 animate-slideUp">
                <h2 class="mb-8 text-gray-800 text-2xl md:text-3xl font-bold">Submit a New Complaint</h2>
                <form method="post" id="complaintForm" class="space-y-6 ">
                    <div>
                        <label for="customerName" class="block mb-2 text-gray-700 font-semibold">Your Name</label>
                        <input type="text" id="customerName" name="cname" placeholder="Enter your full name" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-gray-700 font-semibold">Email Address</label>
                        <input type="email" id="email" name="cemail" placeholder="your.email@example.com" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-gray-700 font-semibold">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="+250 787 723 139" class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
                    </div>
                    <div>
                        <label for="category"  class="block mb-2 text-gray-700 font-semibold">Complaint Category</label>
                        <select id="category" name="category" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100">
                            <option value="">Select a category</option>
                            <option value="Product Quality">Product Quality</option>
                            <option value="Service Issue">Service Issue</option>
                            <option value="Billing">Billing & Payment</option>
                            <option value="Delivery">Delivery & Shipping</option>
                            <option value="Customer Service">Customer Service</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="priority" class="block mb-2 text-gray-700 font-semibold">Priority Level</label>
                        <select id="priority" name="priority" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100">
                            <option value="">Select priority</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div>
                        <label for="subject" class="block mb-2 text-gray-700 font-semibold">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="Brief description of your complaint" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-gray-700 font-semibold">Detailed Description</label>
                        <textarea id="description" name="description" placeholder="Please provide as much detail as possible about your complaint..." required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base min-h-[150px] transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"></textarea>
                    </div>
                    <button type="submit" name="send" class="relative bg-gradient-to-br from-indigo-500 to-purple-600 text-white px-12 py-4 rounded-full font-semibold text-lg shadow-lg transition-all hover:-translate-y-1 hover:shadow-2xl">Submit Complaint</button>
                </form>
            </div>
        </div>

        <!-- View Complaints Section -->
        <div id="view" class="content-area hidden">
            <div class="bg-white/95 backdrop-blur-2xl rounded-3xl p-6 md:p-10 lg:p-16 shadow-2xl border border-white/50 animate-slideUp">
                <h2 class="mb-8 text-gray-800 text-2xl md:text-3xl font-bold">Customer Complaints Status</h2>
                
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-5 mb-8">
                    <div class="bg-white p-4 md:p-6 rounded-2xl text-center shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="text-2xl md:text-3xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent">
                            <?php
                            $sel=$conn->query("SELECT * FROM complaints"); 
                            echo mysqli_num_rows($sel); ?>
                        </div>
                        <div class="text-gray-500 mt-1 text-sm md:text-base">Total Complaints</div>
                    </div>
                    <div class="bg-white p-4 md:p-6 rounded-2xl text-center shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="text-2xl md:text-3xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent">
                            <?php
                            $pending=$conn->query("SELECT * FROM complaints WHERE status='Pending'"); 
                            echo mysqli_num_rows($pending); ?>
                        </div>
                        <div class="text-gray-500 mt-1 text-sm md:text-base">Pending</div>
                    </div>
                    <div class="bg-white p-4 md:p-6 rounded-2xl text-center shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="text-2xl md:text-3xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent">
                            <?php
                            $investigating=$conn->query("SELECT * FROM complaints WHERE status='Investigating'"); 
                            echo mysqli_num_rows($investigating); ?>
                        </div>
                        <div class="text-gray-500 mt-1 text-sm md:text-base">Investigating</div>
                    </div>
                    <div class="bg-white p-4 md:p-6 rounded-2xl text-center shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="text-2xl md:text-3xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent">
                            <?php
                            $resolved=$conn->query("SELECT * FROM complaints WHERE status='Resolved'"); 
                            echo mysqli_num_rows($resolved); ?>
                        </div>
                        <div class="text-gray-500 mt-1 text-sm md:text-base">Resolved</div>
                    </div>
                </div>

                <h2 class="mb-6 md:mb-8 text-gray-800 text-xl md:text-2xl lg:text-3xl text-indigo-500 font-bold">All Complaints</h2>
               
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                    <!-- Complaint Cards -->
                    <?php
                    $sel=$conn->query("SELECT * FROM complaints ORDER BY id DESC");
                    if (mysqli_num_rows($sel) > 0) {
                        while ($row=mysqli_fetch_array($sel)) { ?>
                            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-lg border-l-4 border-indigo-500 transition hover:-translate-y-1 hover:shadow-2xl relative"> 
                                <div class="flex flex-col sm:flex-row justify-between items-start gap-2 sm:gap-0 mb-4">
                                    <span class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white px-3 md:px-4 py-1 rounded-full text-xs font-bold">#C-<?php echo str_pad($row[0], 4, '0', STR_PAD_LEFT); ?></span>
                                    <span class="px-3 md:px-4 py-1 rounded-full text-xs font-bold 
                                        <?php 
                                        if($row[8] == 'Pending') echo 'bg-yellow-100 text-yellow-800';
                                        else if($row[8] == 'Investigating') echo 'bg-blue-100 text-blue-800';
                                        else if($row[8] == 'Resolved') echo 'bg-green-100 text-green-800';
                                        else echo 'bg-gray-100 text-gray-800';
                                        ?>">
                                        <?php echo $row[8]; ?>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-base md:text-lg font-bold text-gray-800 mb-2"><?php echo $row[6]; ?></h3>
                                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 mb-3 text-xs md:text-sm text-gray-500">
                                        <span class="break-all">📦 <?php echo $row[5]?></span>
                                        <span class="break-all">👤 <?php echo $row[1]?></span>
                                    </div>
                                    <p class="text-gray-600 mb-3 text-sm md:text-base break-words">
                                       <?php echo substr($row[7], 0, 150) . (strlen($row[7]) > 150 ? '...' : ''); ?> 
                                    </p>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pt-3 border-t border-gray-100 text-xs md:text-sm">
                                    <span class="font-semibold break-all
                                        <?php 
                                        if($row[4] == 'High') echo 'text-red-600';
                                        else if($row[4] == 'Medium') echo 'text-orange-600';
                                        else echo 'text-green-600';
                                        ?>">
                                        ● <?php echo $row[4]; ?> Priority
                                    </span>
                                    <span class="text-gray-400 text-xs"><?php echo date('M d, Y', strtotime($row['created_at'] ?? 'now')); ?></span>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-2 md:gap-3 mt-4">
                                    <a href="update_complaint.php?id=<?php echo $row[0]; ?>" class="flex-1 bg-gradient-to-br from-blue-500 to-blue-600 text-white px-3 md:px-4 py-2 rounded-lg font-semibold text-xs md:text-sm text-center shadow-md transition-all hover:-translate-y-1 hover:shadow-lg">
                                        ✏️ Edit
                                    </a>
                                    <a href="delete_complaint.php?id=<?php echo $row[0]; ?>" onclick="return confirm('Are you sure you want to delete this complaint?')" class="flex-1 bg-gradient-to-br from-red-500 to-red-600 text-white px-3 md:px-4 py-2 rounded-lg font-semibold text-xs md:text-sm text-center shadow-md transition-all hover:-translate-y-1 hover:shadow-lg">
                                        🗑️ Delete
                                    </a>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 text-lg">No complaints yet. Submit your first complaint!</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Tab switching logic
        function switchTab(tab) {
            document.getElementById('submit').classList.toggle('block', tab === 'submit');
            document.getElementById('submit').classList.toggle('hidden', tab !== 'submit');
            document.getElementById('view').classList.toggle('block', tab === 'view');
            document.getElementById('view').classList.toggle('hidden', tab !== 'view');
            document.getElementById('tab-submit').classList.toggle('active', tab === 'submit');
            document.getElementById('tab-view').classList.toggle('active', tab === 'view');
            if(tab === 'submit') {
                document.getElementById('tab-submit').classList.add('bg-white', 'text-indigo-500');
                document.getElementById('tab-view').classList.remove('bg-white', 'text-indigo-500');
            } else {
                document.getElementById('tab-view').classList.add('bg-white', 'text-indigo-500');
                document.getElementById('tab-submit').classList.remove('bg-white', 'text-indigo-500');
            }
        }
    </script>
</body>
</html>