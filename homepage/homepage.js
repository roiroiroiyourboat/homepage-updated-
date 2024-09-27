//BURGER MENU
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');
    const links = navLinks.querySelectorAll('a'); // Select all the links inside navLinks

    burger.addEventListener('click', () => {
        navLinks.classList.toggle('nav-active');
        burger.classList.toggle('toggle');
    });

    // Add event listeners to each nav link to close the navigation container when clicked
    links.forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('nav-active');
            burger.classList.remove('toggle');
        });
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    const btnLogin = document.getElementById('form_open');
    const btnLaundryService = document.getElementById('openService');
    const login_form = document.getElementById('form_container');
    const laundry_service_form = document.getElementById('service_form');

    //open the login form
    btnLogin.onclick = function() {
        login_form.style.display = 'block';
        laundry_service_form.style.display = 'none';
    }

    //open the service request
    btnLaundryService.addEventListener('click', () => {
            laundry_service_form.style.display = 'block';
            login_form.style.display = 'none';
    });

});

//scrolling effect
window.addEventListener('scroll', () => {
    const scroll = window.pageYOffset / (document.body.offsetHeight - window.innerHeight);
    const scaleValue = 0.5 + (scroll * 0.5); // Scale from 0.5 to 1 based on scroll position
    document.body.style.setProperty('--scale', scaleValue);
}, false);


//POP-UP LOGIN FORM
document.addEventListener('DOMContentLoaded', (event) => {
    const login_form = document.getElementById("form_container");
    const openLogin = document.getElementById("form_open");
    const closeBtn = document.getElementsByClassName("btnClose")[0];

    //open the service form
    openLogin.onclick = function() {
        login_form.style.display = "block";
    }

    //close the service form
    closeBtn.onclick = function() {
        login_form.style.display = "none";
    }

});

document.addEventListener('DOMContentLoaded', (event) => {
    const service_form = document.getElementById("service_form");
    const login_form = document.getElementById("form_container");
    const openLogin = document.getElementById("form_open");
    const openService = document.getElementById("openService");

    //open the login form
    openLogin.onclick = function() {
        login_form.style.display = "block";
        service_form.style.display = 'none';
    }

    //open the service form
    openService.onclick = function() {
        service_form.style.display = "block";
        login_form.style.display = 'none';
    }

});

//pop up for laundry service form
document.addEventListener('DOMContentLoaded', (event) => {
    const service_form = document.getElementById("service_form");
    const openBtn = document.getElementById("openService");
    const closeBtn = document.getElementsByClassName("btnClose")[1];

    //open the service form
    openBtn.onclick = function() {
        service_form.style.display = "block";
    }

    //close the service form
    closeBtn.onclick = function() {
        service_form.style.display = "none";
    }

});

//OVERVIEW PANEL
document.addEventListener('DOMContentLoaded', (event) => {
    const service_overview = document.getElementById("service_overview");
    const service_form = document.getElementById('service_form');
    const closeBtn = document.getElementsByClassName("btnClose")[2];
    const btnBack = document.getElementById('btnBack');

    //close the service overview
    closeBtn.onclick = function() {
        service_overview.style.display = "none";
    }
});

//LAUNNDRY SERVICE DETAILS
document.addEventListener('DOMContentLoaded', (event) => {
    const service_details = document.getElementById('service_details');
    const closeBtn = document.getElementsByClassName("btnClose")[3];

    //close the service overview
    closeBtn.onclick = function() {
        service_details.style.display = "none";
    }

});

function validateContactNumber(input) {
    const regex = /^[0-9]{11}$/;
    if (!regex.test(input.value)) {
        input.setCustomValidity("Please enter a 11-digit number");
    } else {
        input.setCustomValidity("");
    }
}

/***************************LAUNDRY SERVICE REQUEST****************************/
//fetch laundry service
function fetchServices() {
    fetch('/laundry_system/main/homepage/home_configs/fetch_laundry_service.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Debugging
            let dropdown = document.getElementById('service');
            dropdown.innerHTML = '<option selected>--Select Service--</option>'; // Clear existing options
            data.forEach(service => {
                let option = document.createElement('option');
                option.value = service.service_id;
                option.textContent = service.laundry_service_option;
                dropdown.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching services:', error));
}
document.addEventListener('DOMContentLoaded', fetchServices);

//fetch laundry category
function fetchCategories() {
    fetch('/laundry_system/main/homepage/home_configs/fetchLaundryCateg.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Debugging
            let dropdown = document.getElementById('category');
            dropdown.innerHTML = '<option selected>--Select Category--</option>'; //clear existing options
            data.forEach(category => {
                let option = document.createElement('option');
                option.value = category.category_id;
                option.textContent = category.laundry_category_option;
                dropdown.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching categories:', error));
}
//fetch categories when the page loads
document.addEventListener('DOMContentLoaded', fetchCategories);

//fetch price based on the selected laundry service and category
$('#service, #category').change(function() {
    const serviceId = $('#service').val();
    const categoryId = $('#category').val();
  
    if (serviceId && categoryId) {
      $.ajax({
        type: 'GET',
        url: '/laundry_system/main/homepage/home_configs/getPrice.php',
        data: { service_id: serviceId, category_id: categoryId },
        dataType: 'json'
      })
     .done(function(data) {
        console.log('Received data:', data);
        if (data.error === 0) {
          console.log('Setting price to:', data.price);
          $('#price').val(parseFloat(data.price).toFixed(2));
        } else {
          console.log('Error:', data.message);
        }
      })
     .fail(function(xhr, status, error) {
        console.log('Ajax error:', error);
      });
    } else {
      $('#price').val('');
    }
});

//fetch service option (rush/delivery/pick-up)
function fetchServiceOptions() {
    fetch('/laundry_system/main/homepage/home_configs/fetch_service_option.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            let dropdown = document.getElementById('service_option');
            dropdown.innerHTML = '<option selected>--Select Option--</option>'; //clear existing options
            data.forEach(service_option => {
                let option = document.createElement('option');
                option.value = service_option.option_id;
                option.textContent = service_option.option_name;
                dropdown.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching service options:', error));
}
//fetch categories when the page loads
document.addEventListener('DOMContentLoaded', fetchServiceOptions);

//GLOBAL VARIBALE FOR TOTAL IN OVERVIEW PAGE
var totalPrice = 0;

// Function to update the total amount
function updateTotalAmount() {
    var deliveryFee = parseFloat($('#delivery_fee').val()) || 0;
    var rushFee = parseFloat($('#rush_fee').val()) || 0;
    
    var finalTotalAmount = totalPrice + deliveryFee + rushFee;
    $('#total_amount').val(finalTotalAmount.toFixed(2));
}

//fetch service options price
$('#service_option').change(function() {
    const serviceOptionId = $(this).val();
    const selectedOptionText = $(this).find('option:selected').text();
  
    if (selectedOptionText === 'Customer Pick-Up') {
        $('#delivery_fee').val('');  
        updateTotalAmount(); 
    } else if (serviceOptionId) {
        $.ajax({
            type: 'GET',
            url: '/laundry_system/main/homepage/home_configs/getServiceOptionRate.php',
            data: { option_id: serviceOptionId },
            dataType: 'json'
        })
        .done(function(data) {
            console.log('Received data:', data);
            if (data.error === 0) {
                console.log('Setting price to:', data.price);
                if (selectedOptionText === 'Delivery') {
                    $('#delivery_fee').val(parseFloat(data.price).toFixed(2));  
                }
                updateTotalAmount();  // Update total amount after changes
            } else {
                console.log('Error:', data.message);
            }
        })
        .fail(function(xhr, status, error) {
            console.log('Ajax error:', error);
        });
    } else {
        $('#delivery_fee').val(''); 
        updateTotalAmount();
    }
});


//FETCH RUSH PRICE
$('#rush').change(function() {
    if ($(this).is(':checked')) {
        $.ajax({
            type: 'GET',
            url: '/laundry_system/main/homepage/home_configs/getRushFee.php',
            data: {rush: 'Rush'},
            dataType: 'json'
        })
        .done(function(data) {
            console.log('Received data:', data);
            if (data.error === 0) {
                console.log('Setting rush fee to:', data.price);
                $('#rush_fee').val(parseFloat(data.price).toFixed(2));
                updateTotalAmount();
            } else {
                console.log('Error:', data.message);
            }
        })
        .fail(function(xhr, status, error) {
            console.error('Ajax error:', status, error);
            console.error('Response text:', xhr.responseText);
        });
    } else {
        $('#rush_fee').val('');
        updateTotalAmount();
    }
});

var timeoutId;
$('#amount_tendered').on('input', function() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(function() {
        var finalTotalAmount = parseFloat($('#total_amount').val()) || 0;
        var amountTendered = parseFloat($('#amount_tendered').val()) || 0;
        var change = amountTendered - finalTotalAmount;

        console.log('Amount tendered:', amountTendered);
        console.log('Final total amount:', finalTotalAmount);
        console.log('Change:', change);

        $('#change').val(change.toFixed(2));

        if (amountTendered < finalTotalAmount) {
            Swal.fire("Insufficient Amount!", "The amount tendered is less than the total amount.", "warning");
        }
    }, 700); //the sweetalert will only show if the user stops typing for a short period of time
});

$(document).ready(function() {
    var orders = []; // Array to store orders

    //to update customer details in overview section
    function updateCustomerDetails(customerId, customerName, contactNumber) {
        $('#customer_id_display').text(customerId); 
        $('#customer_name_display').text(customerName);
        $('#contact_number_display').text(contactNumber);
    }
    
    function addOrderToOverview(quantity, service, category, weight, price) {
        //computation
        var total = weight * price;  
        totalPrice += total; 

        var orderDetails = '<tr>' +
            '<td>' + quantity + '</td>' +
            '<td>' + service + '</td>' +
            '<td>' + category + '</td>' +
            '<td>' + weight + '</td>' +
            '<td>' + price + '</td>' +
            '<td>' + total.toFixed(2) + '</td>' +
            '</tr>';

        $('#service_overview tbody').append(orderDetails);
        
        updateTotalRow();
    }

    function updateTotalRow() {
        $('#total_row').remove();

        var totalRow = '<tr id="total_row">' +
            '<td colspan="5" style="text-align: right;"><b>Total:</b></td>' +
            '<td>' + totalPrice.toFixed(2) + '</td>' +
            '</tr>';

        $('#service_overview tbody').append(totalRow);
    }

    function resetOrder() {
        totalPrice = 0;
        $('#service_overview tbody').empty();
        updateTotalRow();
    }

    //to show service form and hide overview
    function showServiceForm() {
        $('#service_form').show();
        $('#service_overview').hide();
    }

    function showServiceOverview() {
        $('#service_form').hide();
        $('#service_overview').show();
    }

    // Form submission handling
    $('#form_id').submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'GET',
            url: '/laundry_system/main/homepage/home_configs/weight_limits.php',
            success: function(response) {
                if (response.status === 'success') {
                    var minWeight = parseFloat(response.minWeight);
                    var maxWeight = parseFloat(response.maxWeight);
                    processForm(minWeight, maxWeight);
                } else {
                    swal.fire({ title: "Error", text: "Could not fetch weight limits. Using default values.", icon: "error" });
                }
                
            },
            error: function(xhr, status, error) {
                console.error("Error fetching weight limits: " + error);
                swal.fire({ title: "Error", text: "An error occurred while fetching weight limits. Using default values.", icon: "error" });
            }
        });
    
        function processForm(minWeight, maxWeight) {
            var customerName = $('#customer_name').val();
            var contactNumber = $('#contact_number').val();
            var quantity = $('select[name="quantity"]').val();
            var serviceId = $('select[name="service"]').val();
            var serviceOption = $('select[name="service"] option:selected').text();
            var categoryId = $('select[name="category"]').val();
            var categoryOption = $('select[name="category"] option:selected').text();
            var weight = $('#weight').val();
            var price = $('#price').val();
    
            if (!customerName || !contactNumber || !serviceId || !categoryId || !weight || !price) {
                swal.fire({ title: "Oops..", text: "Please fill in all the required fields.", icon: "error" });
                return;
            }
    
            function validateAndSubmitOrder(weightToSubmit) {
                // Validate if the customer name or contact number already exists
                $.ajax({
                    type: 'POST',
                    url: '/laundry_system/main/homepage/home_configs/validate_customer.php',
                    data: {
                        customer_name: customerName,
                        contact_number: contactNumber
                    },
                    success: function(response) {
                        console.log("Response from server:", response);
                        if (response.status === 'error') {
                            swal.fire({ title: "Oops...", text: response.message, icon: "error" });
                        } else {
                            // If customer name and contact number is available, add order to orders array
                            var order = {
                                customerName: customerName,
                                contactNumber: contactNumber,
                                quantity: quantity,
                                serviceId: serviceId,
                                serviceOption: serviceOption,
                                categoryId: categoryId,
                                categoryOption: categoryOption,
                                weight: weightToSubmit,
                                price: price
                            };
                            orders.push(order);
    
                            // Update customer details in overview section
                            updateCustomerDetails(response.customer_id, customerName, contactNumber);
    
                            // Add order details to the overview table
                            addOrderToOverview(quantity, serviceOption, categoryOption, weightToSubmit, price);
    
                            swal.fire({
                                title: "Order added to list!",
                                text: "You can proceed or add more orders.",
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Clear form inputs except customer name and contact number
                                    $('#form_id').find('input[type="text"], input[type="number"], select').not('#customer_name, #contact_number').val('');
                                    $('#service_form').hide();
                                    $('#service_overview').show();
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Validation Error: " + error);
                        swal.fire({
                            title: "Validation failed!",
                            text: "An error occurred while validating the customer name. Please try again.",
                            icon: "error"
                        });
                    }
                });
            }
    
            var weightValue = parseFloat(weight);
    
            if (weightValue < minWeight) {
                swal.fire({
                    title: "Minimum Weight!",
                    text: `The minimum weight for laundry is ${minWeight} kilos. Do you want to proceed with a 5 kilo order?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        validateAndSubmitOrder(5);
                    } else {
                        $('#form_id').find('input[type="text"], input[type="number"], input[type="tel"], select').val('');
                    }
                });
            } else if (weightValue > maxWeight) {
                swal.fire({
                    title: "Maximum Weight Exceeded!",
                    text: `The maximum weight for laundry is ${maxWeight} kilos. Please reduce the weight.`,
                    icon: "error"
                });
            } else {
                validateAndSubmitOrder(weight);
            }
        }
    });
    
    //cancel button in service req form
    document.getElementById('btnCancel').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Cancel Service Request',
            text: 'Are you sure you want to cancel your service request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                const service_form = document.getElementById('form_id');
                const service_form_con = document.getElementById('service_form');

                service_form.reset();
                service_form_con.style.display = 'none';  
            }
        });
    });

    // "Done" button click on service form
    $('#doneButton').click(function() {
        showServiceOverview();
    });

    // "Back" button click on overview page
    $('#btnBack').click(function() {
        showServiceForm();
    });

    // "Proceed" button click on overview page
    $('#btnProceed').click(function() {
        console.log("btnProceed clicked");
        if (orders.length === 0) {
            swal.fire("No Orders to Proceed!", "Please add at least one order before proceeding.", "warning");
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'laundryService_config.php',
            data: { orders: JSON.stringify(orders),
                    isNewTransaction: 'true'
                },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    swal.fire("Orders saved successfully!", response.message, "success")
                        .then(() => {

                            //Store orders in session storage
                            sessionStorage.setItem('orders', JSON.stringify(orders));
                            
                            orders = [];
                            // resetOrder();
                            $('#service_overview tbody').empty();
                            $('#customer_name_display').empty();
                            $('#contact_number_display').empty();
                            $('#customer_id_display').empty();

                           //pass these order info in service details form
                            $('#customer_id_hidden').val(response.customer_id);
                            $('#service_request_id_hidden').val(response.service_request_id);
                            $('#customer_name_hidden').val(response.customer_name);
                            $('#contact_number_hidden').val(response.contact_number);
                          
                            // Show service form after saving
                            $('#service_details').show();
                            $('#service_overview').hide();

                        });
                } else {
                    swal.fire("Orders not saved!", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                console.error("Save Orders Error: " + error);
                swal.fire("Orders not saved!", "An error occurred while saving your orders. Please try again.", "error");
            }
        });
    });
    
    $('#btnDone_service').click(function() {
        console.log("btnDone_service clicked");
        
        var customerId = $('#customer_id_hidden').val();
        var serviceId = $('select[name="service_option"]').val();
        var serviceOption = $('select[name="service_option"] option:selected').text();
        var isRush = $('#rush').is(':checked') ? 'Rush' : 'Standard';
        var address = $('#address').val();
        var pickupDate = $('#pickup_date').val();
        var deliveryFee = parseFloat($('#delivery_fee').val()) || 0;
        var rushFee = parseFloat($('#rush_fee').val()) || 0;
        var amountTendered = parseFloat($('#amount_tendered').val()) || 0;
        var customerName = $('#customer_name_hidden').val();
        var contactNumber = $('#contact_number_hidden').val();
    
        var finalTotalAmount = totalPrice + deliveryFee + (isRush === 'Rush' ? rushFee : 0);
        var change = amountTendered - finalTotalAmount;
    
        console.log('finalTotalAmount:', finalTotalAmount);
        console.log('change:', change);
        $('#total_amount').val(finalTotalAmount.toFixed(2));
        $('#change').val(change.toFixed(2));
    
        if (!serviceOption || !pickupDate) {
            console.log("Validation failed: Missing serviceOption or pickupDate");
            Swal.fire("Oops!", "Please fill in all the required fields.", "error");
            return;
        } else {
            console.log("Validation passed: serviceOption and pickupDate are present");
        }
    
        var serviceDetails = {
            customer_id: customerId,
            serviceId: serviceId,
            service_option: serviceOption,
            is_rush: isRush,
            address: address,
            pickup_date: pickupDate,
            total_amount: finalTotalAmount.toFixed(2),
            delivery_fee: deliveryFee,
            rush_fee: rushFee,
            amount_tendered: amountTendered.toFixed(2),
            change: change.toFixed(2),
            customer_name: customerName,
            contact_number: contactNumber
        };
    
        $.ajax({
            type: 'POST',
            url: 'saveServiceDetails.php',
            data: serviceDetails,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: "Great! Service details saved successfully.",
                        text: response.message,
                        icon: "success"
                    }).then(() => {
                        resetOrder();
                        $('#form_id')[0].reset();
                        $('#form-service input, #form-service select, #form-service textarea').val('');
    
                        // Update the invoice with service details
                        $('#invoice_customer_id_hidden').text(serviceDetails.customer_id);
                        $('#invoice_name').text(serviceDetails.customer_name);
                        $('#invoice_date').text(new Date().toLocaleString('en-GB', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            hour12: false // 24-hour format
                        }));
                        $('#invoice_contact_number').text(serviceDetails.contact_number);
                        $('#invoice_address').text(serviceDetails.address);
                        $('#invoice_service_type').text(serviceDetails.service_option);
                        $('#invoice_pickup_delivery_date').text(serviceDetails.pickup_date);

                        var orders = JSON.parse(sessionStorage.getItem('orders')) || [];

                        orders.forEach(order => {
                            var serviceRow = `
                                <tr>
                                    <td>${order.serviceOption}</td>
                                    <td>${order.categoryOption}</td>
                                    <td>${order.quantity}</td>
                                    <td>${order.weight}</td>
                                    <td>${order.price}</td>
                                </tr>
                            `;
                            $('#services-table tbody').append(serviceRow);
                        });
    
                        if ($('#services-table tbody tr.additional-fees').length === 0) {
                            var additionalFeesRow = `
                                <tr class="additional-fees">
                                    <td colspan="4">Delivery Fee</td>
                                    <td>₱${deliveryFee.toFixed(2)}</td>
                                </tr>
                                ${isRush === 'Rush' ? `<tr class="additional-fees"><td colspan="4">Rush Fee</td><td>₱${rushFee.toFixed(2)}</td></tr>` : ''}
                                <tr class="additional-fees">
                                    <td colspan="4"><strong>Total Amount</strong></td>
                                    <td><strong>₱${finalTotalAmount.toFixed(2)}</strong></td>
                                </tr>
                            `;
    
                            $('#services-table tbody').append(additionalFeesRow);
                        }
    
                        // Show the invoice container
                        $('#print_invoice').show();
                        $('#print_invoice_btn').show();
                        console.log("Invoice data set and container shown.");
                    });
                } else {
                    Swal.fire("Service details not saved!", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                console.error("Save Service Details Error: " + error);
                Swal.fire("Service details not saved!", "An error occurred while saving the service details. Please try again.", "error");
            }
        });
    })

    function printInvoice() {
        var printButton = document.getElementById('print_invoice_btn');
        printButton.style.display = 'none';
        
        var printContents = document.querySelector('.print_invoice').outerHTML; 
        
        // Use a new window for printing
        var newWindow = window.open('', '', 'height=600,width=800');
        
        // Write HTML and styles to the new window
        newWindow.document.write('<html><head><title>Invoice</title>');
        newWindow.document.write('<style>' +
            '@media print {' +
                '@page {' +
                    'size: 80mm;' + //size of thermal paper
                    'margin: 0;' +
                '}' +
                
                '.print_invoice {' +
                    'display: block;' +
                    'position: static;' +
                    'background-color: transparent;' +
                    'padding: 10px;' + 
                    'width: 100%;' +
                    'max-width: 80mm;' +  
                '}' + 

                'hr{' + 
                'border: 1px solid; margin: 5px 0}' +

                '.logo_header, h3{' + 
                'font-size: 14px;}' +
                
                '.text-center{' +
                    'text-align: center;' +
                    'font-size: 12px;' +
                '}' +
                
                '#services-table {' +
                    'width: 70mm;' + 
                    'border-collapse: collapse;' +
                    'margin: 0 auto;' + 
                '}' +
                
                'th, td {' +
                    'border: 1px solid black;' +
                    'padding: 2px;' + 
                    'text-align: left;' +
                    'font-size: 10px;' + 
                '}' +
        
                'body {' +
                    'margin: 0;' + 
                    'padding: 0;' +
                    'font-size: 12px;' + 
                '}' +
            '}' +
        '</style>');   
        
        newWindow.document.write('</head><body>');
        newWindow.document.write(printContents);
        newWindow.document.write('</body></html>');
        
        newWindow.document.close(); // Close the document to apply styles
        newWindow.print(); // Trigger the print dialog
        
        // Reset UI elements
        printButton.style.display = 'block';
        $('#print_invoice tbody').empty();
        $('#print_invoice').hide();
        $('#service_details').hide();
    }
    
    
    $('#print_invoice_btn').click(printInvoice);
    
    $('#btnCancel_service_details').click(function() {
        swal.fire({
            title: 'Cancel Service Request',
            text: 'Are you sure you want to cancel your service request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                var serviceRequestId = $('#service_request_id_hidden').val();
                var customerId = $('#customer_id_hidden').val();
                console.log('Service Request ID:', serviceRequestId);
                console.log('Customer ID:', customerId);

                $.ajax({
                    type: 'POST',
                    url: 'cancel_service_details.php',
                    data: { 
                        service_request_id: serviceRequestId, 
                        customer_id: customerId
                    },
                    dataType: 'json'
                })
            .done((response) => {
                    console.log('Response:', response);
                    if (response.status === 'success') {
                        swal.fire("Service request canceled successfully!", response.message, "success")
                    .then((result) => {
                            if (result.isConfirmed) { 
                                resetOrder();
                                $('#form-service input, #form-service select, #form-service textarea').val('');
                                $('#form_id')[0].reset();
                                $('#service_details').hide();
                                $('#service_form').show();
                            }
                        });
                    } else {
                        swal.fire("Service request cancellation failed!", response.message, "error");
                    }
                })
            .fail((xhr, status, error) => {
                    console.error("Cancel Service Request Error:", error);
                    swal.fire("Service request cancellation failed!", "An error occurred while canceling your service request. Please try again.", "error");
                });
            }
        });
    });

    //Cancel service request button click on overview page
    $('#btnCancel_service').click(function() {
        swal.fire({
            title: 'Cancel Service Request',
            text: 'Are you sure you want to cancel your service request?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                resetOrder();
                $('#customer_id_display').empty();
                $('#service_overview tbody').empty();
                $('#customer_name_display').empty();
                $('#contact_number_display').empty();
                $('#form_id')[0].reset();
                showServiceForm();
            }
        });
    });
});
