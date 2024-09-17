<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    //connection
    $conn = new mysqli('localhost', 'root','','laundry_db');
    if($conn->connect_error){
        die('Failed to connect : '.$conn->connect_error);
    } else {
        //stmt means statement
        $stmt = $conn->prepare("select * from user where email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt_result = $stmt->get_result();


        if($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();
            //if more than 1 ang rows use while loop instead of if-else
            if($data['password'] === $password){
                //echo "<div class='alert alert-success' role='alert'>
                //Login successfully. <a href='dashboard.php' class='alert-link'>Go to Dashboard</a></div>";
                header('location:dashboard.php');
                
            }else{
                echo "<script>alert('Invalid E-mail or Password')</script>";
            }
        }else {
            echo "<script>alert('Invalid E-mail or Password')</script>";
        }
    }
?>