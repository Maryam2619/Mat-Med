<?php
// DB connection
$conn = mysqli_connect("localhost", "root", "", "materiamedica");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
include('../layout/header.php');


// Get selected filters
$selectedAlphabet = isset($_GET['alpha']) ? $_GET['alpha'] : '';
$selectedCategoryID = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Fetch categories dynamically
$categoryQuery = "SELECT Category_ID, Category_Name FROM remedy_categories ORDER BY Category_Name";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = [];
while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categories[] = $row;
}

// Build remedies query
$sql = "
    SELECT r.Remedy_ID, r.Remedy_Name, c.Category_Name 
    FROM remedies r
    JOIN remedy_categories c ON r.Category_ID = c.Category_ID
    WHERE 1=1
";

if (!empty($selectedAlphabet)) {
    $sql .= " AND r.Remedy_Name LIKE '" . $conn->real_escape_string($selectedAlphabet) . "%'";
}

if (!empty($selectedCategoryID)) {
    $sql .= " AND r.Category_ID = " . intval($selectedCategoryID);
}

$sql .= " ORDER BY r.Remedy_Name ASC";

$result = $conn->query($sql);
$remedies = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $remedies[] = $row;
    }
}
?>

<body class="bg-light mt-5 d-flex flex-column min-vh-100">
    <div class="container py-5 flex-grow-1">
        <h2 class="mb-4 text-center">List of Remedies</h2>

        <!-- Category Filter -->
        <div class="mb-3 text-center">
            <!-- <strong>Filter by Category:</strong> -->
            <?php foreach ($categories as $category): ?>
                <a href="?category=<?= $category['Category_ID'] ?>&alpha=<?= urlencode($selectedAlphabet) ?>" 
                   class="btn btn-outline-success btn-sm m-1 <?= ($selectedCategoryID == $category['Category_ID']) ? 'active' : '' ?>">
                   <?= htmlspecialchars($category['Category_Name']) ?>
                </a>
            <?php endforeach; ?>
            <a href="?alpha=<?= urlencode($selectedAlphabet) ?>" class="btn btn-outline-dark btn-sm m-1">All Categories</a>
        </div>

        <!-- Alphabetical Filter -->
        <div class="mb-4 text-center">
            <!-- <strong>Filter by Alphabet:</strong> -->
            <?php foreach (range('A', 'Z') as $letter): ?>
                <a href="?alpha=<?= $letter ?>&category=<?= urlencode($selectedCategoryID) ?>"
                   class="btn btn-outline-success btn-sm m-1 <?= ($selectedAlphabet == $letter) ? 'active' : '' ?>">
                   <?= $letter ?>
                </a>
            <?php endforeach; ?>
            <a href="?category=<?= urlencode($selectedCategoryID) ?>" class="btn btn-outline-dark btn-sm m-1">All</a>
        </div>

        <!-- Remedy List -->
        <div class="card shadow-sm">
            <div class="card-body">
                <?php if (count($remedies) > 0): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($remedies as $remedy): ?>
                            <li class="list-group-item">
                                <a href="remedy_detail.php?id=<?= urlencode($remedy['Remedy_ID']) ?>" class="text-decoration-none fw-bold text-success">
                                    <?= htmlspecialchars($remedy['Remedy_Name']) ?>
                                </a>
                                <span class="badge bg-success text-light float-end"><?= htmlspecialchars($remedy['Category_Name']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted text-center">No remedies found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include '../layout/footer.php'; ?>

</body>
</html>
