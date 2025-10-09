<?php
include "database/config.php";
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
    echo "<script>alert('email alreay in use')</script>";
   } else{

   $insert=$conn->query("INSERT INTO complaints(customer_name,customer_email ,customer_phone_number ,complaint_category, priority,subject,description)
   VALUES('$name','$email','$phone','$category','$priority','$subject','$description')");
   if ($insert) {
    echo "inserted";
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
        <header class="text-center mb-12 animate-fadeInDown">
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
            <div class="bg-white/95 backdrop-blur-2xl rounded-3xl p-10 md:p-16 shadow-2xl border border-white/50 animate-slideUp">
                <h2 class="mb-8 text-gray-800 text-2xl md:text-3xl font-bold">Customer Complaints status</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
                    <div class="bg-white p-6 rounded-2xl text-center shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="text-3xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent">
                            
                            <?php
                            $sel=$conn->query("SELECT * FROM complaints"); 
                            echo mysqli_num_rows($sel); ?>

                        </div>
                        <div class="text-gray-500 mt-1 text-base">Total Complaints</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl text-center shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="text-3xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent">0</div>
                        <div class="text-gray-500 mt-1 text-base">Pending</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl text-center shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="text-3xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent">0</div>
                        <div class="text-gray-500 mt-1 text-base">Investigating</div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl text-center shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="text-3xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent">0</div>
                        <div class="text-gray-500 mt-1 text-base">Resolved</div>
                    </div>
                </div>

                <h2 class="mb-8 text-gray-800 text-2xl md:text-3xl text-indigo-500 font-bold">Complaints</h2>
               

                <div class="grid grid-cols-1 md:grid-cols-2  gap-6">
                    <!-- Sample Complaint 1 -->
                    <?php
                    $sel=$conn->query("SELECT * FROM complaints");
                    while ($row=mysqli_fetch_array($sel)) { ?>
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-indigo-500 transition hover:-translate-y-1 hover:shadow-2xl relative"> 
                        <div class="flex justify-between items-start mb-4">
                            <span class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white px-4 py-1 rounded-full text-xs font-bold">#C-2024-001</span>
                            <span class="px-4 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800"><?php echo $row[8]; ?></span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Defective Product Received</h3>
                            <div class="flex gap-4 mb-3 text-sm text-gray-500">
                                <span>📦 <?php echo $row[5]?></span>
                                <span>👤 <?php echo $row[1]?></span>
                            </div>
                            <p class="text-gray-600 mb-3 text-wrap">
                               <?php echo $row[7]; ?> 
                            </p>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100 text-sm border-2 ">
                            <span class="font-semibold text-red-600 line-clamp-1">● <?php echo $row[6]; ?></span>
                            <span class="text-gray-400 text-xs">2 hours ago</span>
                        </div>
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
        // Dummy filter function
        function filterComplaints(type) {
            // Implement filtering logic here
        }
    </script>
</body>
</html>
