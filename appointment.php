<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $service  = $_POST['service'];
    $date     = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO appointments (name, email, phone, service, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $service, $date);
    if ($stmt->execute()) {
        $message = "✅ Appointment booked successfully!";
    } else {
        $message = "❌ Failed to book appointment.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>📅 Book Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eaf4f4;
            padding: 40px;
            text-align: center;
        }

        h2 {
            color: #007bff;
        }

        form {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            display: inline-block;
            text-align: left;
            max-width: 450px;
            width: 100%;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px;
            margin: 10px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #218838;
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
            color: #333;
        }

        a.back-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

    <h2>📅 Book an Appointment</h2>

    <form method="POST" action="">
        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Phone Number</label>
        <input type="text" name="phone" required>

        <label>Choose a Service</label>
        <select name="service" required>
            <option value="">-- Select Service --</option>
            <option>General Consultation</option>
            <option>Maternity Services</option>
            <option>Lab Tests</option>
            <option>Dental Care</option>
            <option>Pharmacy</option>
            <option>Pediatrics</option>
            <option>Emergency</option>
        </select>

        <label>Preferred Date</label>
        <input type="date" name="date" required>

        <button type="submit">Book Now</button>
    </form>

    <?php if (!empty($message)): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <a class="back-link" href="index.php">← Back to Homepage</a>

</body>
</html>
