<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Honeypot check
  if (!empty($_POST['honeypot'])) {
    // If the honeypot field is filled, discard as spam
    die("Spam detected.");
  }

  // reCAPTCHA verification
  $recaptchaSecret = 'YOUR_SECRET_KEY'; // Replace with your actual reCAPTCHA secret key
  $recaptchaResponse = $_POST['g-recaptcha-response'];

  // Verify reCAPTCHA response
  $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
  $responseKeys = json_decode($response, true);

  if (!$responseKeys["success"]) {
    die("reCAPTCHA verification failed. Please try again.");
  }

  // Sanitize inputs
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

  // Set up email details
  $to = "your-email@example.com"; // Replace with your actual email
  $subject = "Interest in Domain - 2port.com";
  $body = "Name: $name\nEmail: $email\nMessage: $message";
  $headers = "From: webmaster@2port.com";

  // Send the email
  if (mail($to, $subject, $body, $headers)) {
    echo "Thank you for your interest! We’ll get back to you soon.";
  } else {
    echo "Oops! Something went wrong. Please try again later.";
  }
}
?>