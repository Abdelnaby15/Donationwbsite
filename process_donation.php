<?php
// Include database connection
include('db_connection.php');

// Get form data
$amount = $_POST['amount'];
$payment_method = $_POST['payment_method'];
$country_code = $_POST['country_code'];
$user_id = 1;  // Assuming user ID is passed or obtained through a session

// Additional fields based on payment method
$mobile_number = null;
$card_number = null;
$expiry_date = null;
$cvv = null;

if ($payment_method === 'visa_card') {
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
} else {
    $mobile_number = $_POST['mobile_number'];
}

// Validate form data
if (empty($amount) || empty($payment_method) || empty($country_code)) {
    echo "All fields are required!";
    exit;
}

// Example of payment method handling (simulating payment for now)
$payment_status = 'Pending';  // Set default payment status to Pending
$payment_details = "Payment method: $payment_method, Country Code: $country_code";

// Process the donation (simulate success)
if ($payment_method === 'visa_card') {
    // Here, you would integrate with a real payment gateway API to process Visa payments.
    // Simulate a successful Visa Card payment.
    $payment_status = 'Completed';
} else {
    // For other payment methods (Vodafone Cash, Orange Cash, etc.), simulate success.
    $payment_status = 'Completed';
}

// Insert the donation into the database
$query = "INSERT INTO donations (user_id, donation_amount, payment_status, payment_method, country_code, mobile_number, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("idssssssss", $user_id, $amount, $payment_status, $payment_method, $country_code, $mobile_number, $card_number, $expiry_date, $cvv);

if ($stmt->execute()) {
    echo "Thank you for your donation!";
} else {
    echo "Error processing the donation.";
}
?>
