<?php
// 1️⃣ PHP LOGIC AT THE TOP
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role  = $_POST['role'];
    $level = $_POST['level'];

    // save to DB (example)
    // mysqli_query($conn, "INSERT INTO users (...) VALUES (...)");

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Unified Edu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/register_new.css">
</head>
<body>

<div class="register-container">

    <!-- REGISTER FORM CARD -->
    <div class="register-card">
        <h2>Create Account</h2>
        <p class="subtitle">Start your learning journey today</p>

        <form action="register_process.php" method="POST">


            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>
            <label>Role</label>
<select name="role" required>
    <option value="">Select Role</option>
    <option value="teacher">Teacher</option>
    <option value="student">Student</option>
</select>

            <label>Education Level</label>
            <select name="education" required>
                <option value="">Select Level</option>
                <option value="kindergarten">Kindergarten</option>
                <option value="primary">Primary School</option>
                <option value="secondary">Secondary School</option>
                <option value="highschool">High School</option>
                <option value="undergraduate">Undergraduate</option>
                <option value="postgraduate">Post-Graduate</option>
            </select>

            <button type="submit">Register</button>

        </form>
    </div>

    <!-- INFO SECTION -->
    <div class="register-info">
    <div class="info-content">
        <i class="fas fa-graduation-cap fa-3x" style="color:#ff7f50; margin-bottom:15px;"></i>
        <h2>Unified Education Platform</h2>
        <p>One platform for every stage of learning — from Kindergarten to Post-Graduation.</p>
        <div class="info-box">
            ⭐ Kids Friendly • School Ready • Career Focused
        </div>
    </div>
</div>


</div>

<!-- OTP POPUP -->
<div id="otpPopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); justify-content:center; align-items:center;">
    
    <div style="background:#fff; padding:30px; border-radius:8px; text-align:center; width:300px;">
        <h3>Email Verification</h3>
        <p>Enter the OTP sent to your email</p>

        <input type="text" id="otpInput" placeholder="Enter OTP" style="width:100%; padding:10px; margin-top:10px;">
        <br><br>

        <button onclick="verifyOTP()" style="padding:10px 20px;">Verify</button>
<br><br>

<p id="timer" style="color:red;">Resend OTP in 60s</p>

<button onclick="resendOTP()" id="resendBtn" disabled>
Resend OTP
</button>
    </div>

</div>

<script>

function verifyOTP(){

let otp = document.getElementById("otpInput").value;

fetch("verify_otp.php",{
method:"POST",
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:"otp="+otp
})
.then(res=>res.text())
.then(data=>{

if(data=="success"){
alert("Registration Successful");
window.location="login.php";
}else{
alert("Invalid OTP");
}

});

}

</script>

<script>

function verifyOTP(){

let otp = document.getElementById("otpInput").value;

fetch("verify_otp.php",{
method:"POST",
headers:{'Content-Type':'application/x-www-form-urlencoded'},
body:"otp="+otp
})
.then(res=>res.text())
.then(data=>{

if(data=="success"){
alert("Registration Successful");
window.location="login.php";
}else{
alert("Invalid OTP");
}

});

}


let timeLeft = 60;

let timer = setInterval(function(){

timeLeft--;

document.getElementById("timer").innerText =
"Resend OTP in " + timeLeft + "s";

if(timeLeft <= 0){

clearInterval(timer);

document.getElementById("timer").innerText =
"You can resend OTP";

document.getElementById("resendBtn").disabled=false;

}

},1000);


function resendOTP(){

fetch("resend_otp.php")
.then(res=>res.text())
.then(data=>{

alert("OTP Sent Again");

timeLeft=60;

document.getElementById("resendBtn").disabled=true;

});

}

</script>
<?php if(isset($_GET['otp'])){ ?>
<script>
document.getElementById("otpPopup").style.display="flex";
</script>
<?php } ?>
</body>
</html>
