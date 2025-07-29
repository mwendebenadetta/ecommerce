<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Location - Mutu-ini Hospital</title>
</head>
<body>
    <h2>Select Your Location</h2>
    <form action="set_location.php" method="post">
        <label for="location">Choose a location:</label>
        <select name="location" id="location">
            <option value="Nairobi">Nairobi</option>
            <option value="Kisumu">Kisumu</option>
            <option value="Mombasa">Mombasa</option>
        </select>
        <button type="submit">Save Location</button>
    </form>
</body>
</html>
