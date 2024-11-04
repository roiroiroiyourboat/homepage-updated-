<?php
session_start();

//to check if user is verified
if (!isset($_SESSION['verified_user'])) {
    echo "<script>
    alert('Access denied. Please complete verification first.');
    </script>";
    exit;
}

//to handle form submission for password reset
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //to get input data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    //to retrieve new password and confirmation from the POST data
    $new_password = isset($data['new_pass']) ? trim($data['new_pass']) : '';
    $confirm_password = isset($data['con_password']) ? trim($data['con_password']) : '';

    if (empty($new_password) || empty($confirm_password)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    if ($new_password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    //validate password strength (8-20 characters, letters and numbers, no spaces or special characters)
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/', $new_password)) {
        echo json_encode(['success' => false, 'message' => 'Password must be 8-20 characters long, contain letters and numbers, and no spaces or special characters.']);
        exit;
    }

    $conn = new mysqli('localhost', 'root', '', 'laundry_db');

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    //retrieve username from session
    $username = $_SESSION['verified_user'];

    //hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    //to update the password in the database
    $query = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $query->bind_param("ss", $hashed_password, $username);

    if ($query->execute()) {
        //to clear session variable after successful password reset
        unset($_SESSION['verified_user']);
        echo json_encode(['success' => true, 'message' => 'Password has been reset successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating password.']);
    }

    $conn->close();
    exit; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your password</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            background-color: #d4d8f0;
        }
        
        .password-wrapper {
            position: relative;
        }

        /* show password */
        .password-wrapper .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2rem;
        }

        .container-md {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 720px;
            background-color: #fffffe;
            border-radius: 8px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;
            padding: 20px;
        }
    </style>

</head>
<body>
    <div class="container-md">
        <div class="container">
            <form id="resetForm">
                <h3 class="text-center">Password</h3>
                <p class="text-center">Choose a strong password.</p>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New password</label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control" id="new_pass" name="new_pass" minlength="8" maxlength="20">
                        <i class='bx bx-show toggle-password' data-target="#new_pass"></i>
                    </div>  
                    <div id="passwordHelpBlock" class="form-text">
                            Your password must be 8-20 characters long, 
                            contain uppercase and lowercase letters and numbers, and must not contain spaces, special characters, or emoji.
                    </div>   
                </div>
                <div class="mb-3">
                    <label for="confirm_pass" class="form-label">Confirm new password</label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control" id="con_password" name="con_password">
                        <i class='bx bx-show toggle-password' data-target="#con_password"></i>
                    </div>  
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary me-md-2" type="submit">Change Password</button>
                </div>
            </form>
        </div>
    </div>

    <script>
         //show password
        $('.toggle-password').click(function() {
            var target = $(this).data('target');
            var input = $(target);
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                $(this).removeClass('bx-show').addClass('bx-hide');
            } else {
                input.attr('type', 'password');
                $(this).removeClass('bx-hide').addClass('bx-show');
            }
        });

        //to handle reset password form
        $('#resetForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const jsonData = Object.fromEntries(formData.entries());

            console.log("Form Data:", jsonData); 

            fetch('reset_password.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(jsonData),
            })
            .then(response => {
                console.log("Response Status:", response.status); 
                return response.json();
            })
            .then(data => {
                console.log("Response Data:", data);
                alert(data.message);
                if (data.success) {
                    window.location.href = 'homepage.php'; 
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });


    </script>
</body>
</html>