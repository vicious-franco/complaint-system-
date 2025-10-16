<?php
include "database/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $complaint = $conn->query("SELECT * FROM complaints WHERE id='$id'");
    $data = mysqli_fetch_array($complaint);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['cname'];
    $email = $_POST['cemail'];
    $phone = $_POST['phone'];
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $update = $conn->query("UPDATE complaints SET 
        customer_name='$name',
        customer_email='$email',
        customer_phone_number='$phone',
        complaint_category='$category',
        priority='$priority',
        subject='$subject',
        description='$description',
        status='$status'
        WHERE id='$id'");
    
    if ($update) {
        echo "<script>alert('Complaint updated successfully'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error updating complaint'); window.location.href='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Complaint</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-400 to-purple-700 min-h-screen p-5 font-sans">
    <div class="max-w-4xl mx-auto">
        <header class="text-center mb-8">
            <h1 class="text-white text-4xl font-bold mb-2 drop-shadow-lg">Update Complaint</h1>
            <a href="index.php" class="text-white/90 hover:text-white underline">← Back to Home</a>
        </header>
        
        <div class="bg-white/95 backdrop-blur-2xl rounded-3xl p-10 md:p-16 shadow-2xl border border-white/50">
            <form method="post" class="space-y-6">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                
                <div>
                    <label class="block mb-2 text-gray-700 font-semibold">Your Name</label>
                    <input type="text" name="cname" value="<?php echo $data['customer_name']; ?>" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
                </div>
                
                <div>
                    <label class="block mb-2 text-gray-700 font-semibold">Email Address</label>
                    <input type="email" name="cemail" value="<?php echo $data['customer_email']; ?>" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
                </div>
                
                <div>
                    <label class="block mb-2 text-gray-700 font-semibold">Phone Number</label>
                    <input type="tel" name="phone" value="<?php echo $data['customer_phone_number']; ?>" class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
                </div>
                
                <div>
                    <label class="block mb-2 text-gray-700 font-semibold">Complaint Category</label>
                    <select name="category" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100">
                        <option value="Product Quality" <?php if($data['complaint_category']=='Product Quality') echo 'selected'; ?>>Product Quality</option>
                        <option value="Service Issue" <?php if($data['complaint_category']=='Service Issue') echo 'selected'; ?>>Service Issue</option>
                        <option value="Billing" <?php if($data['complaint_category']=='Billing') echo 'selected'; ?>>Billing & Payment</option>
                        <option value="Delivery" <?php if($data['complaint_category']=='Delivery') echo 'selected'; ?>>Delivery & Shipping</option>
                        <option value="Customer Service" <?php if($data['complaint_category']=='Customer Service') echo 'selected'; ?>>Customer Service</option>
                        <option value="Other" <?php if($data['complaint_category']=='Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
                
                <div>
                    <label class="block mb-2 text-gray-700 font-semibold">Priority Level</label>
                    <select name="priority" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100">
                        <option value="Low" <?php if($data['priority']=='Low') echo 'selected'; ?>>Low</option>
                        <option value="Medium" <?php if($data['priority']=='Medium') echo 'selected'; ?>>Medium</option>
                        <option value="High" <?php if($data['priority']=='High') echo 'selected'; ?>>High</option>
                    </select>
                </div>
                
                <div>
                    <label class="block mb-2 text-gray-700 font-semibold">Status</label>
                    <select name="status" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100">
                        <option value="Pending" <?php if($data['status']=='Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Investigating" <?php if($data['status']=='Investigating') echo 'selected'; ?>>Investigating</option>
                        <option value="Resolved" <?php if($data['status']=='Resolved') echo 'selected'; ?>>Resolved</option>
                    </select>
                </div>
                
                <div>
                    <label class="block mb-2 text-gray-700 font-semibold">Subject</label>
                    <input type="text" name="subject" value="<?php echo $data['subject']; ?>" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"/>
                </div>
                
                <div>
                    <label class="block mb-2 text-gray-700 font-semibold">Detailed Description</label>
                    <textarea name="description" required class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-base min-h-[150px] transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100"><?php echo $data['description']; ?></textarea>
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" name="update" class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white px-12 py-4 rounded-full font-semibold text-lg shadow-lg transition-all hover:-translate-y-1 hover:shadow-2xl">Update Complaint</button>
                    <a href="index.php" class="bg-gray-500 text-white px-12 py-4 rounded-full font-semibold text-lg shadow-lg transition-all hover:-translate-y-1 hover:shadow-2xl inline-block text-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>