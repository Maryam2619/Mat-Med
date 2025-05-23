<?php
// 🔹 Connect to your database
$conn = new mysqli("localhost", "root", "", "materiamedica");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 🔹 Get query from frontend
$query = $_GET['q'] ?? '';

if ($query) {
    $query = $conn->real_escape_string($query);

     // 🔹 Extended search: remedy name, description, or symptom name
     $sql = "SELECT DISTINCT r.Remedy_ID, r.Remedy_Name, r.Description 
     FROM remedies r
     LEFT JOIN remedy_symptom rs ON r.Remedy_ID = rs.Remedy_ID
     LEFT JOIN symptoms s ON rs.Symptom_ID = s.Symptom_ID
     WHERE r.Remedy_Name LIKE '%$query%' 
        OR r.Description LIKE '%$query%'
        OR s.Symptom_Description LIKE '%$query%'
     LIMIT 10";
 

    $result = $conn->query($sql);
    $suggestions = array();

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $remedyID = $row['Remedy_ID'];
            $remedyName = $row['Remedy_Name'];
            $description = $row['Description'];

            // 🔹 Fetch symptoms for each remedy
            $symptomSQL = "SELECT s.Symptom_Description 
                           FROM symptoms s
                           INNER JOIN remedy_symptom rs ON s.Symptom_ID = rs.Symptom_ID
                           WHERE rs.Remedy_ID = $remedyID";

            $symptomResult = $conn->query($symptomSQL);
            $symptomList = [];

            if ($symptomResult && $symptomResult->num_rows > 0) {
                while ($symptomRow = $symptomResult->fetch_assoc()) {
                    $symptomList[] = $symptomRow['Symptom_Description'];
                }
            }

            $symptomString = implode(", ", $symptomList);

            $suggestions[] = [
                'id' => $remedyID,
                'name' => $remedyName,
                'desp' => $description,
                'symptoms' => $symptomString
            ];
        }
    }
    
    // 🔹 Send JSON response to JS
    echo json_encode($suggestions);
}

$conn->close();
?>
