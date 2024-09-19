<?php
require 'vendor/autoload.php'; // Make sure the mPDF library is included

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

    $sql = "SELECT * FROM $table $searchQuery";
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

function exportData($type, $data) {
    switch ($type) {
        case 'csv':
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="inquiries.csv"');
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Website', 'Name', 'Email', 'Phone', 'Country']); // Header row
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
            exit; // Ensure no further output is sent

        case 'excel':
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="inquiries.xls"');
            echo '<table border="1"><tr><th>Website</th><th>Name</th><th>Email</th><th>Phone</th><th>Country</th></tr>';
            foreach ($data as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['website']) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                echo '<td>' . htmlspecialchars($row['country']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            exit; // Ensure no further output is sent

        case 'pdf':
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML('<h1>Inquiries</h1>');
            $mpdf->WriteHTML('<table border="1" cellpadding="5"><tr><th>Website</th><th>Name</th><th>Email</th><th>Phone</th><th>Country</th></tr>');
            foreach ($data as $row) {
                $mpdf->WriteHTML('<tr>');
                $mpdf->WriteHTML('<td>' . htmlspecialchars($row['website']) . '</td>');
                $mpdf->WriteHTML('<td>' . htmlspecialchars($row['name']) . '</td>');
                $mpdf->WriteHTML('<td>' . htmlspecialchars($row['email']) . '</td>');
                $mpdf->WriteHTML('<td>' . htmlspecialchars($row['phone']) . '</td>');
                $mpdf->WriteHTML('<td>' . htmlspecialchars($row['country']) . '</td>');
                $mpdf->WriteHTML('</tr>');
            }
            $mpdf->WriteHTML('</table>');
            $mpdf->Output('inquiries.pdf', 'D');
            exit; // Ensure no further output is sent

        default:
            echo "Invalid export type";
            exit; // Ensure no further output is sent
    }
}

// Fetch data for export
$host = "localhost";
$username = "root";
$password = "";
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
$search = isset($_GET['search']) ? $_GET['search'] : '';

foreach ($websites as $website) {
    $data = fetchDataFromDatabase(
        $host, $username, $password, $website['dbname'], $website['table'], 
        $search
    );

    foreach ($data as $row) {
        $row['website'] = $website['domain'];
        $allData[] = $row;
    }
}

$type = isset($_GET['type']) ? $_GET['type'] : '';
exportData($type, $allData);
