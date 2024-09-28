<?php
date_default_timezone_set('Asia/Manila');

$conn = new mysqli('localhost', 'root', '', 'laundry_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT delivery_day FROM settings WHERE setting_id = 1";
$result = $conn->query($sql);
$deliveryDays = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $deliveryDays = $row['delivery_day'];
}

$defaultPickupDate = date('Y-m-d', strtotime("+$deliveryDays days"));

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Azia Skye's Laundry | Homepage </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="homepage.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>

<body>
    <!--NAV BAR-->
    <header class="header">
        <nav class="navbar">
            <img src="/laundry_system/main/images/laundry-logo.png" class="laundry_icon">
                <div class="logo">Azia Skye's Laundry</div>
                    <ul class="nav-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about_us">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#home">
                            <button class="button" id="openService">Service Request</button>
                        </a></a></li>
                        <li><a href="#home">
                            <button class="button" id="form_open">Login</button>
                        </a></li>
                    </ul>
                </div>
                <div class="burger">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
        </nav>
            <div class="progress"></div>
    </header>
    
    <!--HOME-->
    <section class="home" id="home">
        <div class="content">
            <div class="home-content">
                <h1>We wash, you wear, and enjoy your weekend!</h1>
            </div>
            <img src="/laundry_system/main/images/laundry_home.svg" alt="Laundry Home">
        </div>

        <!--LOGIN-->
        <div class="form_container" id="form_container">
                <div class = "login_form">
                    <div class="logo_header">
                        <header>
                            <img src="/laundry_system/main/images/laundry-logo.png" alt="logo">      
                        </header>
                        <button type="button" class="btnClose" onclick="closeForm()"><i class='bx bx-x bx-rotate-90'></i></button>
                        <h4>Welcome back!</h4>
                        <h5>Login</h5>
                    </div>

                    <form action="/laundry_system/main/homepage/login.php" method="post">
                        <div class="row">
                            <div class="col">
                                <label for="form-label">Username</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                            
                        <div class="row">
                            <div class="col">
                                <label for="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="links">
                            <span><a href="forgot_password.php">Forgot Password? </a></span>
                        </div>                            
                            <div class="input-box">
                                <input type="submit" class="btn" value="Login">
                            </div>
                    </form>
                </div>
        </div>

        <!--POP UP LAUNDRY SERVICE FORM-->
        <div class="service_form" id="service_form">
            <form method="post" class="form-container" id="form_id">
                <div class="logo_header">
                    <header>
                        <img src="/laundry_system/main/images/laundry-logo.png" alt="logo">    
                    </header>
                    <h5 class="text-center">Service Request</h5>
                    <button type="button" class="btnClose" onclick="closeForm()"><i class='bx bx-x bx-rotate-90'></i></button>
                </div>
                <hr style="border: 1px solid #b8c1ec; margin: 16px"> <!--this line will create a horizontal line-->
                
                <div class="row">
                    <h5 class="text-center">Customer Details</h5>
                    <div class="col">
                        <label for="form-label"><b>Customer Name</b></label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name"
                            placeholder="Enter customer name" autocomplete="off">
                    </div>

                    <div class="col">
                        <label for="form-label"><b>Contact Number</b></label>
                        <input type="tel" class="form-control" id="contact_number" name="contact_number"
                            placeholder="Enter customer number" autocomplete="off"  maxlength="11" oninput="validateContactNumber(this)">
                    </div>
                </div>

                <div class="row">
                    <h5 class="text-center">Laundry Information</h5>
                    <div class="col">
                        <label for="form-label"><b>Quantity</b></label>
                        <select name="quantity" class="form-control">
                            <option selected>--Select Quantity--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="form-label"><b>Laundry Service</b></label>
                        <select name="service" class="form-control" id="service">
                            <option selected>--Select Service--</option>
                        </select>
                    </div>

                    <div class="col">
                        <label for="form-label"><b>Laundry Category</b></label>
                        <select name="category" class="form-control" id="category">
                            <option selected>--Select Category--</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="form-label"><b>Weight(kg)</b></label>
                        <input type="number" class="form-control" step="0.01" id="weight" name="weight" autocomplete="off" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="form-label"><b>Price</b></label>
                        <input type="number" class="form-control" id="price" name="price" autocomplete="off" readonly>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" class="btn btn-danger" id="btnCancel">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit" >Add to list</button>
                    <button type="button" class="btn btn-success" id="doneButton">Done</button>
                </div>
        </div>

        <!--------------- SERVICE OVERVIEW--------------->
        <div class="service_overview" id="service_overview">
            <div class="overview_container">
                <div class="logo_header">
                    <header>
                        <img src="/laundry_system/main/images/laundry-logo.png">     
                    </header>
                    <h5 class="text-center">Service Request Overview</h5>
                    <button type="button" class="btnClose"><i class='bx bx-x bx-rotate-90'></i></button>
                </div>
                
                <hr style="border: 1px solid #b8c1ec; margin: 18px 0;"> 

                <div class="container mt-2" id="overview">
                    <h6 class="text-center">Customer Number: <span id="customer_id_display"></h5>
                    <div class="mb-4">
                        <div class="row">
                            <div class="col">
                                <h6>Customer Name: <span id="customer_name_display"></span></h6>
                            </div>
                            <div class="col">
                                <h6>Contact Number: <span id="contact_number_display"></span></h6>
                            </div>
                        </div> 
                    </div>
                                
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped ">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Service</th>
                                        <th>Category</th>
                                        <th>Weight (kg)</th>
                                        <th>Price (₱)</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                            <tbody id="order_list">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="buttons">
                    <button type="button" class="btn btn-secondary" id="btnBack">Back</button>
                    <button type="button" class="btn btn-success" id="btnProceed">Proceed</button>
                    <button type="button" class="btn btn-danger" id="btnCancel_service">Cancel</button>
                </div>
            </div>
        </div>

        <!---------------LAUNDRY SERVICE DETAILS---------------------->
        <div class="service_details" id="service_details">
            <div class="service_req_container">
                <form method="post" class="form-container" id="form-service">
                    <div class="logo_header">
                        <header>
                            <img src="/laundry_system/main/images/laundry-logo.png" alt="logo">
                        </header>
                        <h5 class="text-center">Service Request</h5>
                        <button type="button" class="btnClose"><i class='bx bx-x bx-rotate-90'></i></button>
                    </div>

                    <hr style="border: 1px solid #b8c1ec; margin: 18px 0;"> 

                    <!----CUSTOMER DETAILS---->
                    <input type="hidden" id="customer_id_hidden" name="customer_id">
                    <input type="hidden" id="service_request_id_hidden" name="service_request_id">
                    <input type="hidden" id="customer_name_hidden" name="customer_name_hidden">
                    <input type="hidden" id="contact_number_hidden" name="contact_number_hidden">

                    <div class="row">       
                        <h5 class="text-center">Service Details</h5>
                        <div class="col">
                            <label for="form-label"><b>Service Option</b></label>
                            <select name="service_option" class="form-control" id="service_option">
                                <option selected>--Select Option--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Rush" id="rush">
                                <label class="form-check-label" for="rush"><b>Rush</b></label>
                                <p>Get your order delivered as soon as possible.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="form-label"><b>Address</b></label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="form-label"><b>Pickup/Delivery Date</b></label>
                            <input type="date" class="form-control" id="pickup_date" name="pickup_date" value="<?php echo $defaultPickupDate; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <h5 class="text-center">Charges</h5>
                        <div class="col">
                            <label for="form-label"><b>Delivery Fee</b></label>
                            <input type="number" class="form-control" id="delivery_fee" name="delivery_fee"
                                autocomplete="off" readonly>
                        </div>
                        
                        <div class="col">
                            <label for="rush_fee" class="form-label"><b>Rush Fee</b></label>
                            <input type="number" class="form-control" id="rush_fee" name="rush_fee" autocomplete="off" readonly>
                        </div>
                    </div>

                    <hr style="margin: 16px;">

                    <div class="row">
                        <div class="col">
                            <label for="form-label"><b>Total Amount</b></label>
                            <input type="number" class="form-control" id="total_amount" name="total_amount"
                                autocomplete="off" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="form-label"><b>Amount Tendered</b></label>
                            <input type="number" class="form-control" id="amount_tendered" name="amount_tendered"
                                autocomplete="off">
                        </div>

                        <div class="col">
                            <label for="form-label"><b>Change</b></label>
                            <input type="number" class="form-control" id="change" name="change"
                                autocomplete="off" readonly>
                        </div>
                    </div>

                    <div class="buttons">
                        <button type="button" class="btn btn-danger" id="btnCancel_service_details">Cancel</button>
                        <button type="button" class="btn btn-success" id="btnDone_service">Done</button>
                    </div>
                </form>
            </div>
        </div> <!--END OF SERVICE DETAILS-->

        <!-------INVOICE-------->
        <div class="print_invoice" id="print_invoice" style="display:none;">
            <div class="invoice_container" id="invoice_container">
                <div class="logo_header">
                    <h5 class="text-center">Azia Skye's Laundry <br>
                        <span>Verde Heights, City of San Jose del Monte, Bulacan</span> <br>
                        <span>0995-062-8516 / 0991-370-9729</span>
                    </h5>
                </div>
                <hr>
                
                <div id="invoice-details" class="mb-4">
                    <h6>Customer No: <span id="invoice_customer_id_hidden"></span></h6>

                    <div class="row">
                        <div class="col">
                            <h6>Name: <span id="invoice_name"></span></h6>
                        </div>

                        <div class="col">
                            <h6>Date: <span id="invoice_date"></span></h6>

                        </div>
                    </div>

                    <h6>Contact Number: <span id="invoice_contact_number"></span></h6>
                    <h6>Address: <span id="invoice_address"></span></h6>
                    
                    <div class="table-responsive">
                        <span>Service Details</span>
                        <table class="table table-bordered" id="services-table">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Weight</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Service details will be inserted here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <h6>Service Type: <span id="invoice_service_type"></span></h6>
                    <h6>Pickup/Delivery Date: <span id="invoice_pickup_delivery_date"></span></h6>

                    <button type="button" class="btn btn-primary" id="print_invoice_btn" style="display: none;">Print Invoice</button>
                </div>

            </div>
        </div>

    </section>

    <!--ABOUT US-->
    <section class="about-us" id="about_us">
        <div class="aboutUs-content">
            <h1>ABOUT US</h1>
            <h3 class="text-center">Laundry Service for your convenience</h3>

            <div class="about-us-pro">
                <div class="card-container">
                    <div class="card">
                        <img src="/laundry_system/main/images/expert_cleaner.png" class="zoom-image">
                        <div class="card-content">
                            <h2>Expert Cleaner</h2>
                        </div>
                    </div>


                    <div class="card">
                        <img src="/laundry_system/main/images/affordable_price.png" class="zoom-image">
                        <div class="card-content">
                            <h2>Affordable Price</h2>
                        </div>
                    </div>

                    <div class="card">
                        <img src="/laundry_system/main/images/delivery.png" class="zoom-image">
                        <div class="card-content">
                            <h2>Delivery</h2>
                        </div>
                    </div>
                </div> <!--end of card container-->
            </div>

            <!--OUR SERVICES-->
            <h1 class="text-center">OUR SERVICES AND RATES</h1>
            <div class="our-services">
                <div class="card-container2">
                    <div class="card2">
                        <img src="/laundry_system/main/images/service-WDF.png" class="zoom-image">
                        <div class="card-content">
                            <h3>Wash/Dry/Fold</h3>
                            <h4>Minimum 5/kilos</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <td> Clothes, Table Napkin, Pillowcase</td>
                                    <td class="table-danger"> ₱35</td>
                                </tr>
                                <tr>
                                    <td> Bedsheets, Table Cloths, Curtains</td>
                                    <td class="table-danger"> ₱55</td>
                                </tr>
                                <tr>
                                    <td>Comforter, Bath Towel</td>
                                    <td class="table-danger"> ₱65</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card2">
                        <img src="/laundry_system/main/images/service-WDP.png" class="zoom-image">
                        <div class="card-content">
                            <h3>Wash/Dry/Press</h3>
                            <h4>Minimum 5/kilos</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <td> Clothes, Table Napkin, Pillowcase</td>
                                    <td class="table-danger"> ₱80</td>
                                </tr>
                                <tr>
                                    <td> Bedsheets, Table Cloths, Curtains</td>
                                    <td class="table-danger"> ₱100</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card2">
                        <img src="/laundry_system/main/images/service-D.png" class="zoom-image">
                        <div class="card-content">
                            <h3>Dry Only</h3>
                            <h4>Minimum 5/kilos</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <td> Clothes, Table Napkin, Pillowcase</td>
                                    <td class="table-danger"> ₱35</td>
                                </tr>
                                <tr>
                                    <td> Bedsheets, Table Cloths, Curtains</td>
                                    <td class="table-danger"> ₱45</td>
                                </tr>
                                <tr>
                                    <td>Comforter, Bath Towel</td>
                                    <td class="table-danger"> ₱55</td>
                                </tr>
                            </table>
                        </div> <!--CLOSING card-content-->
                    </div> <!--CLOSING card2-->
                </div> <!--CLOSING CARD CONTAINER2-->
            </div> <!--CLOSING OUR SERVICES-->
        </div> <!-- CLOSING aboutUs-content-->
    </section>

    <!--footer-->
    <footer>
        <div class="footer-container" id="contact">
            <div class="footer-section">
                <div class="business_name">
                    <h1>AZIA SKYE'S LAUNDRY SHOP</h1>
                </div>
            </div>

            <div class="footer-section">
                <h2>BUSINESS HOURS</h2>
                <p><strong>MONDAY TO SUNDAY</strong> <br> 8:00 AM - 6:00 PM</p>
            </div>

            <div class="footer-section">
                <h2>CONTACT US</h2>
                <div class="call">
                    <i class='bx bxs-phone-call'></i>
                    <p>0995-062-8516 <br> 0991-370-9729</p>
                </div>
            </div>

            <div class="footer-section">
                <h2>OUR LOCATION</h2>
                <div class="map-container">
                    <h5>Verde Heights, City of San Jose del Monte, Bulacan</h5>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15429.758101734158!2d121.0463696!3d14.8005702!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397afa59f7a236b%3A0xeedc8d815ddd4067!2sBrent%20Erwin!5e0!3m2!1sen!2sph!4v1717215267505!5m2!1sen!2sph"
                        width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="homepage.js"></script>
</body>

</html>