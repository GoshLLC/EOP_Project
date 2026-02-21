<?php
$conn = new mysqli("localhost", "root", "", "Eastern_Oregon_Pets_Database");

if ($conn->connect_error) {
    die("Database connection failed");
}

$search = $_GET['q'] ?? '';

$stmt = $conn->prepare("
    SELECT * FROM animals
    WHERE name LIKE ?
    OR species LIKE ?
    OR breed LIKE ?
");

$term = "%" . $search . "%";
$stmt->bind_param("sss", $term, $term, $term);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
    echo "Species: " . htmlspecialchars($row['species']) . "<br>";

    if (!empty($row['image'])) {
        echo "<img src='animal_photos/" . htmlspecialchars($row['image']) . "' width='200'><br>";
    }

    echo "Status: " . htmlspecialchars($row['status']) . "<hr>";
}

$stmt->close();
$conn->close();
?>