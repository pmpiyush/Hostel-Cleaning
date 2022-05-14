<?php
session_start();
require("db.php");

$errors = array();

// ========================= LOGIN STUDENT =======================
if(isset($_POST['studentLogin'])){
  $rollnumber = mysqli_real_escape_string($db, $_POST['studentRoll']);
  $password = mysqli_real_escape_string($db, $_POST['studentPass']);
  $rollnumber =$rollnumber;
	$res=mysqli_query($db,"select * from student where rollnumber='$rollnumber'");
	$check=mysqli_num_rows($res);
	if($check>0){
		$row=mysqli_fetch_assoc($res);	
		$dbpassword=$row['password'];	
    echo"".$dbpassword."or ".$password;	 
				if($password=$dbpassword){
                session_start();
                $box=$_SESSION['username'] = $rollnumber;
                	setcookie('uname',$box,time()+(48*60*60));
                  header("location: ./allot.php");
					$arr=array('Status'=>'Login Success','Success Message'=>'Login Successfuly, Please Wait to Redirect....');					  
				}
        else{
					$arr=array('Status'=>'Login Failed','Error Message'=>'Please enter correct password');				 
			} 
	 
	}
  else{
		$arr=array('Status'=>'Login Failed','Error Message'=>'Please enter correct Roll no');
	}
	echo json_encode($arr);
}

// ========================= LOGIN ADMIN` =======================
if(isset($_POST['adminLogin'])){
  $adminUsername = mysqli_real_escape_string($db, $_POST['adminUsername']);
  $adminPassword = mysqli_real_escape_string($db, $_POST['adminPassword']);
  
  $adminPassword = md5($adminPassword);
  $query_find_admin = "select * from admin where username='$adminUsername'";
  $result_find_admin = mysqli_query($db,$query_find_admin);
  if (mysqli_num_rows($result_find_admin) == 1) {
    $row = mysqli_fetch_assoc($result_find_admin);
    if($adminPassword == $row['password']){
      $_SESSION['username'] = $adminUsername;
      $_SESSION['admin_logged'] = "You are now logged in";
      header("Location: allot.php");
    }else{
      array_push($errors, "Wrong password! Please try again.");
    }
  }else {
    array_push($errors, "Admin not found!");
  }
}

?>