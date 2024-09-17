<?php
// Function to fetch data from a specific database and table
function fetchDataFromDatabase($host, $username, $password, $dbname, $table, $searchValue, $orderColumn, $orderDir, $start, $length) {
    // Create a connection to the database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get columns in the table
    $existingColumns = [];
    $result = $conn->query("SHOW COLUMNS FROM $table");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $existingColumns[] = $row['Field'];
        }
    }

    // Handle search query
    $searchQuery = "";
    if (!empty($searchValue)) {
        $searchTerms = explode(' ', $searchValue);
        $searchConditions = [];
        foreach ($existingColumns as $col) {
            if (in_array($col, ['name', 'email', 'phone', 'country'])) {
                foreach ($searchTerms as $term) {
                    $searchConditions[] = "$col LIKE '%" . $conn->real_escape_string($term) . "%'";
                }
            }
        }
        if (!empty($searchConditions)) {
            $searchQuery = " WHERE " . implode(" OR ", $searchConditions);
        }
    }

    // Handle ordering
    $orderQuery = "";
    if (!empty($orderColumn) && in_array($orderColumn, $existingColumns)) {
        $orderQuery = " ORDER BY $orderColumn $orderDir";
    } else {
        $orderQuery = " ORDER BY id DESC"; // Default to latest records on top
    }

    // SQL query to fetch data with search and order
    $sql = "SELECT " . implode(', ', $existingColumns) . " FROM $table $searchQuery $orderQuery LIMIT $start, $length";
    $result = $conn->query($sql);

    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Get total records count for the filtered data
    $countResult = $conn->query("SELECT COUNT(*) as count FROM $table $searchQuery");
    $filteredRecords = $countResult ? $countResult->fetch_assoc()['count'] : 0;

    $conn->close();
    return [$data, $filteredRecords];
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

$allData = [];
$filteredTotalRecords = 0;

// Fetch data for each database and table
foreach ($websites as $website) {
    list($data, $filteredRecords) = fetchDataFromDatabase(
        $host, $username, $password, $website['dbname'], $website['table'], 
        isset($_POST['search']) ? $_POST['search'] : '', 
        isset($_POST['order']) ? $_POST['order']['column'] : 'id', 
        isset($_POST['order']) ? $_POST['order']['dir'] : 'DESC', 
        isset($_POST['start']) ? intval($_POST['start']) : 0, 
        isset($_POST['length']) ? intval($_POST['length']) : 10
    );
    foreach ($data as $row) {
        $row['website'] = $website['domain'];
        $allData[] = $row;
    }
    $filteredTotalRecords += $filteredRecords;
}

// Pagination variables
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$recordsPerPage = $length;

// Calculate total pages
$totalPages = ceil($filteredTotalRecords / $recordsPerPage);

// Ensure page is within valid bounds
$page = max(1, min($page, $totalPages));

// Calculate start index for the current page
$startIndex = ($page - 1) * $recordsPerPage;

// Prepare response data
$response = [
    "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
    "recordsTotal" => $filteredTotalRecords,
    "recordsFiltered" => $filteredTotalRecords,
    "data" => array_slice($allData, $startIndex, $recordsPerPage),
    "pagination" => [
        "currentPage" => $page,
        "totalPages" => $totalPages,
        "hasPrevious" => $page > 1,
        "hasNext" => $page < $totalPages
    ]
];

// Debugging output
// Uncomment the following lines to debug data and pagination issues
// error_log("Page: $page, Total Pages: $totalPages, Records Per Page: $recordsPerPage");
// error_log("Data: " . print_r($response['data'], true));

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
