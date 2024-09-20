<?php
// Function to fetch data from a specific database and table
function fetchDataFromDatabase($host, $username, $password, $dbname, $table, $searchValue) {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $searchQuery = "";
    if (!empty($searchValue)) {
        $searchQuery = " WHERE name LIKE '%" . $conn->real_escape_string($searchValue) . "%' 
                         OR email LIKE '%" . $conn->real_escape_string($searchValue) . "%' 
                         OR phone LIKE '%" . $conn->real_escape_string($searchValue) . "%' 
                         OR country LIKE '%" . $conn->real_escape_string($searchValue) . "%'";
    }

    // Assuming the table has a 'created_at' or similar column for ordering
    $sql = "SELECT $table.*, DATE_FORMAT(`date`, '%d-%m-%Y %H:%i:%s') AS formatted_date FROM $table $searchQuery ORDER BY `id` DESC";
    $result = $conn->query($sql);

    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();
    return $data;
}

// Database connection details
$host = "localhost";
$username = "root";
$password = "";

// Define databases and tables
$websites = [
    ['dbname' => 'qurascxb_classesuk', 'table' => 'form2', 'domain' => 'quranclasses.uk'],
    ['dbname' => 'qurascxb_qtus', 'table' => 'tbl2', 'domain' => 'quranteacher.us'],
    ['dbname' => 'qurascxb_quraanclassesus', 'table' => 'tbl2', 'domain' => 'quraanclasses.us'],
    ['dbname' => 'qurascxb_quranteacherscouk', 'table' => 'tbl2', 'domain' => 'quranteachers.co.uk'],
    ['dbname' => 'qurascxb_quranteacheruk', 'table' => 'tbl2', 'domain' => 'onlinequranteacher.uk'],
    ['dbname' => 'qurascxb_learnquraanus', 'table' => 'tbl2', 'domain' => 'learnquraan.us']
];

$allData = [];
$search = isset($_POST['search']) ? $_POST['search'] : '';
$lastUpdateTime = isset($_POST['lastUpdateTime']) ? intval($_POST['lastUpdateTime']) : 0;

// Fetch data and track the latest update time
$latestUpdateTime = 0;

foreach ($websites as $website) {
    $data = fetchDataFromDatabase(
        $host, $username, $password, $website['dbname'], $website['table'], 
        $search
    );

    foreach ($data as $row) {
        // Update the latest update time based on the 'date' field or whatever field indicates the most recent update
        $rowDate = strtotime($row['date']);
        if ($rowDate > $latestUpdateTime) {
            $latestUpdateTime = $rowDate;
        }
        $row['website'] = $website['domain'];
        $allData[] = $row;
    }
}

// Pagination logic
$currentPage = isset($_POST['page']) ? intval($_POST['page']) : 1;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;

$totalRecords = count($allData);
$totalPages = ceil($totalRecords / $length);
$currentPage = max(1, min($currentPage, $totalPages));

// If on the last page but no records, reset to first page
if ($currentPage === $totalPages && empty(array_slice($allData, ($currentPage - 1) * $length, $length))) {
    $currentPage = 1;
}

// Slice data for current page
$dataForCurrentPage = array_slice($allData, ($currentPage - 1) * $length, $length);

// Prepare the response
$response = [
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords,
    "data" => $dataForCurrentPage,
    "pagination" => [
        "currentPage" => $currentPage,
        "totalPages" => $totalPages,
        "hasPrevious" => $currentPage > 1,
        "hasNext" => $currentPage < $totalPages,
        "startRecord" => ($currentPage - 1) * $length + 1,
        "endRecord" => min($totalRecords, $currentPage * $length)
    ],
    "lastUpdate" => $latestUpdateTime // Send the latest update time to the client
];

header('Content-Type: application/json');
echo json_encode($response);
