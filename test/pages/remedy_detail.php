<?php
// remedy_detail.php
include('../layout/header.php');

$remedy_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Check if 'id' is in URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Always sanitize input

    // Connect to your database
    $conn = new mysqli("localhost", "root", "", "materiamedica");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

        // Fetch remedy + category name
        $sql = "
        SELECT r.*, c.Category_Name AS category_name 
        FROM remedies r 
        LEFT JOIN remedy_categories c ON r.Category_ID = c.Category_ID
        WHERE r.Remedy_ID = $id
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $remedy = $result->fetch_assoc();

        // Fetch symptoms linked to this remedy using JOIN
        $sql_symptoms = "
    SELECT s.Symptom_Description AS symptom_Description, sc.Category_Name AS Category_Name
    FROM symptoms s
    INNER JOIN remedy_symptom rsl ON s.Symptom_ID = rsl.symptom_id
    INNER JOIN symptom_categories sc ON s.Category_ID = sc.Category_ID
    WHERE rsl.Remedy_ID = $id
";
        $symptom_result = $conn->query($sql_symptoms);

        $symptoms = [];
        
        if ($symptom_result->num_rows > 0) {
            while ($row = $symptom_result->fetch_assoc()) {
                $symptoms[] =[
                    'symptom' => $row['symptom_Description'],
                    'category' => $row['Category_Name']        
                ] ;

            }
        }
    } else {
        echo "No remedy found.";
        exit;
    }
    $conn->close();
} else {
    echo "No remedy ID provided.";
    exit;
}

?>

<body class="d-flex flex-column min-vh-100 bg-light">
<!-- <div class="container flex-grow-1"> -->
    <!-- Hero Section -->
    <div class="hero text-center bg-success text-light pt-5 pb-5 px-4 mt-5">
        <h1 class="pt-4"><?php echo htmlspecialchars($remedy['Remedy_Name']); ?></h1>
        <p class="px-4"><?php echo nl2br(htmlspecialchars($remedy['Synonyms'])); ?></p>
    </div>
    <!-- </div> -->
    <!-- </div> -->

    <!-- Remedy Details Section -->
    <div class="container mt-4">
        <div class="row">
            <!-- <div class="col-md-4 text-center">
                <img src="close-up-medicine-pills-table.jpg" class="img-fluid" alt="Remedy Image">
            </div> -->

            <div class="col-md-12"> 
                <div class="remedy-card">
                    <h3>About the Remedy</h3>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($remedy['category_name']); ?></p>
                    <p><strong>Description:<br></strong> <?php echo htmlspecialchars($remedy['Description']); ?></p>
                    <p><strong>Symptoms Treated:</strong></p>
                    <ul>
                        <?php foreach ($symptoms as $item): ?>
                            <li>
                                <?php echo htmlspecialchars($item['symptom']); ?>
                                <em style="color: gray;">(<?php echo htmlspecialchars($item['category']); ?>)</em>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- <p><strong>Preparation:</strong><?php echo htmlspecialchars($remedy['Preparation']); ?></p> -->
                    <p><strong>Potency:</strong> <?php echo htmlspecialchars($remedy['Potency']); ?></p>
                </div>
            </div>
        </div>
    </div>
    </div> 

    <!-- Footer -->
    <?php include '../layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
const remedyId = <?php echo $remedy_id; ?>;

function checkMatch() {
    const symptom = document.getElementById('symptomInput').value.trim();

    if (symptom === "") {
        document.getElementById('matchResult').innerHTML = "<p style='color:red;'>Please enter a symptom.</p>";
        return;
    }

    fetch('check_match.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `symptom=${encodeURIComponent(symptom)}&remedy_id=${remedyId}`
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('matchResult').innerHTML = data;
    });
}
</script>
</body>
</html>
