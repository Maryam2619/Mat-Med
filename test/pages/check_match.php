<?php
$conn = mysqli_connect("localhost", "root", "", "materiamedicafinal");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['symptom']) && isset($_POST['remedy_id'])) {
    $inputSymptom = strtolower(trim($_POST['symptom']));
    $remedy_id = intval($_POST['remedy_id']);

    $query = "SELECT Symptom_Description FROM symptoms 
              JOIN remedy_symptom ON symptoms.Symptom_ID = remedy_symptom.Symptom_ID 
              WHERE remedy_symptom.Remedy_ID = $remedy_id";
    $result = mysqli_query($conn, $query);

    $bestMatchScore = 0;
    $bestMatchSymptom = "";

    while ($row = mysqli_fetch_assoc($result)) {
        $dbSymptom = strtolower($row['Symptom_Description']);
        similar_text($inputSymptom, $dbSymptom, $similarity);

        if ($similarity > $bestMatchScore) {
            $bestMatchScore = round($similarity, 2);
            $bestMatchSymptom = $dbSymptom;
        }
    }

    $threshold = 50;  // Set your minimum acceptable similarity here

    if ($bestMatchScore >= $threshold) {
        // Bar Color Logic
        $barColor = "red";
        if ($bestMatchScore >= 70) {
            $barColor = "green";
        } elseif ($bestMatchScore >= 40) {
            $barColor = "orange";
        }

        echo "<p><b>Closest Match:</b> $bestMatchSymptom</p>";
        echo "<p><b>Match Score:</b> $bestMatchScore%</p>";
        echo "
        <div style='width:100%; background:#f0f0f0; border-radius:8px; overflow:hidden; margin-top:5px;'>
            <div style='width:$bestMatchScore%; background:$barColor; height:20px; text-align:center; color:white; font-weight:bold;'>
                $bestMatchScore%
            </div>
        </div>";
    } else {
        echo "<p>No similar symptoms found for this remedy.</p>";
    }
} else {
    echo "<p>Please enter a symptom to check.</p>";
}
?>
