<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Our Services - Mutu-ini Hospital</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f8fb;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #2c3e50;
      color: white;
      padding: 30px 0;
      text-align: center;
    }

    h1 {
      margin: 0;
      font-size: 36px;
      letter-spacing: 1px;
    }

    .services-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 40px 20px;
      gap: 30px;
    }

    .service-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 30px;
      max-width: 300px;
      text-align: center;
      transition: transform 0.3s ease;
    }

    .service-card:hover {
      transform: translateY(-8px);
    }

    .service-card h3 {
      color: #28a745;
      margin-bottom: 15px;
    }

    .service-card p {
      color: #555;
      font-size: 16px;
      line-height: 1.5;
    }

    .back-link {
      display: block;
      text-align: center;
      margin: 40px 0;
    }

    .back-link a {
      text-decoration: none;
      color: white;
      background-color: #28a745;
      padding: 12px 25px;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .back-link a:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <header>
    <h1>🛠️ Our Services</h1>
  </header>

  <div class="services-container">
    <div class="service-card">
      <h3>🩺 Outpatient & Inpatient Care</h3>
      <p>We offer 24/7 access to top-tier medical care for all patients — both in-person and through appointments.</p>
    </div>

    <div class="service-card">
      <h3>📦 Medical Supplies Resale</h3>
      <p>Resellers can list, manage, and sell medical-related products through our ecommerce portal.</p>
    </div>

    <div class="service-card">
      <h3>📅 Appointment Booking</h3>
      <p>Clients can easily book appointments with our team online. Fast, simple, and hassle-free.</p>
    </div>

    <div class="service-card">
      <h3>📄 PDF Export for Orders</h3>
      <p>Download order and report summaries in beautiful PDF format for printing or sharing.</p>
    </div>

    <div class="service-card">
      <h3>💬 WhatsApp Support</h3>
      <p>Instant help and support via our official WhatsApp line. We're just a message away!</p>
    </div>
  </div>

  <div class="back-link">
    <a href="index.php">← Back to Home</a>
  </div>

</body>
</html>
