<?php
// Define variables
$company_name = "[Your Company Name]";
$company_address = "[Your Address]";
$company_city_state_zip = "[City, State, ZIP Code]";
$company_email = "[Your Email]";
$company_phone = "[Your Phone Number]";
$recipient_name = "[Recipient Name]";
$recipient_address = "[Recipient Address]";
$recipient_city_state_zip = "[City, State, ZIP Code]";

$date = date('F j, Y'); // current date

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy Agreement</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; line-height: 1.6;">
        <p><strong><?php echo $company_name; ?></strong><br>
        <?php echo $company_address; ?><br>
        <?php echo $company_city_state_zip; ?><br>
        <?php echo $company_email; ?><br>
        <?php echo $company_phone; ?><br>
        <strong>Date:</strong> <?php echo $date; ?></p>

        <p><strong><?php echo $recipient_name; ?></strong><br>
        <?php echo $recipient_address; ?><br>
        <?php echo $recipient_city_state_zip; ?></p>

        <h3>Subject: Privacy Policy Agreement</h3>

        <p>Dear <?php echo $recipient_name; ?>,</p>

        <p>This Privacy Policy Agreement ("Agreement") outlines the terms and conditions regarding the collection, use, and protection of personal information provided by <?php echo $company_name; ?> ("Company") and the user ("You").</p>

        <p>By accessing and using our services, you acknowledge that you have read, understood, and agreed to comply with the terms of this Privacy Policy.</p>

        <h4>1. Information Collection and Use</h4>
        <p>We collect personal data such as name, email address, phone number, and other relevant information to provide better services. The collected data is used solely for the purposes stated in this agreement and will not be shared with third parties without consent.</p>

        <h4>2. Data Protection</h4>
        <p>We implement strict security measures to ensure the confidentiality and integrity of your personal information. Our systems are designed to prevent unauthorized access, disclosure, or alteration of collected data.</p>

        <h4>3. User Rights</h4>
        <p>You have the right to access, update, or delete your personal data at any time by contacting us at <?php echo $company_email; ?>. You may also withdraw consent for data usage by submitting a written request.</p>

        <h4>4. Third-Party Disclosure</h4>
        <p>We do not sell, trade, or rent personal information to third parties. However, we may disclose data when required by law or in compliance with legal obligations.</p>

        <h4>5. Changes to Privacy Policy</h4>
        <p>We reserve the right to update this Privacy Policy as necessary. Any modifications will be communicated via email or updated on our official website.</p>

        <h4>6. Acceptance of Terms</h4>
        <p>By signing below, you confirm that you have read, understood, and agreed to the terms of this Privacy Policy Agreement.</p>

        <p>Sincerely,<br>
        <strong><?php echo $company_name; ?></strong><br>
        <?php echo $company_address; ?><br>
        <?php echo $company_city_state_zip; ?><br>
        <strong><?php echo $company_email; ?></strong><br>
        <strong><?php echo $company_phone; ?></strong><br>
        <br>
        <strong>Acknowledgment and Agreement:</strong></p>

        <p>I, <strong><?php echo $recipient_name; ?></strong>, acknowledge that I have read and understood the Privacy Policy Agreement and agree to the terms stated.</p>

        <p><strong>Signature:</strong> ___________________________<br>
        <strong>Date:</strong> ___________________________</p>
    </div>
</body>
</html>
