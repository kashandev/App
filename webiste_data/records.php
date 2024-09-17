<?php
// Function to fetch count of records from a specific database and table
function getRecordCountFromDatabase($host, $username, $password, $dbname, $table) {
    // Create a connection to the database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to count records
    $sql = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($sql);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $count = $result->fetch_assoc()['count'];

    $conn->close();
    return $count;
}

// Database connection details
$host = "localhost";
$username = "root";
$password = "";

// Define databases and tables
$websites = [
    ['dbname' => 'qurascxb_classesuk', 'table' => 'form', 'domain' => 'quranclasses.uk'],
    ['dbname' => 'qurascxb_qtus', 'table' => 'tbl', 'domain' => 'quranteacher.us'],
    ['dbname' => 'qurascxb_quraanclassesus', 'table' => 'tbl', 'domain' => 'quraanclasses.us'],
    ['dbname' => 'qurascxb_quranteacherscouk', 'table' => 'tbl', 'domain' => 'quranteachers.co.uk'],
    ['dbname' => 'qurascxb_quranteacheruk', 'table' => 'tbl', 'domain' => 'onlinequranteacher.uk'],
    ['dbname' => 'qurascxb_learnquraanus', 'table' => 'tbl', 'domain' => 'learnquraan.us'],
    ['dbname' => 'qurascxb_seo', 'table' => 'tbl', 'domain' => 'iseoagency.co.uk']
];

$counts = [];

// Fetch record count for each database and table
foreach ($websites as $website) {
    $count = getRecordCountFromDatabase(
        $host, $username, $password, $website['dbname'], $website['table']
    );
    $counts[$website['domain']] = $count;
}

// Prepare response data
$response = [
    "data" => $counts
];

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
