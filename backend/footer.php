<!-- footer --> 

    <section class="footer">

        <div class="container">

            <div class="copyright">

                <h6><?php echo $now ?> Main Panel All Rights Reserved Developed By <a href="" target="_blank">Kashan</a> </h6>

            </div>

        </div>

    </section>

<!-- /.footer --> 

<?php

   // include modal //

   include_once('modal/modal.php'); // this is used for include modal //

    // end of include modal // ?>  

</html>

<!-- /.html -->

<!-- Javascript Links -->

<script src="public/admin/plugins/jQuery/jQuery-2.1.3.min.js"></script>

<script type="text/javascript" src="public/js/intlTelInput-jquery.min.js"></script>

<script src="public/js/main-script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="public/admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script src="public/admin/plugins/fastclick/fastclick.min.js"></script>

<script src="public/js/select2.js"></script>

<script src="public/js/datepicker.js"></script>

<script src="public/js/jstree.min.js"></script>

<!-- /.Javascript Links -->


<script>

let currentPage = 1;
let totalPages = 1;
const recordsPerPage = 10;
let requestInProgress = false;
let lastUpdate = Date.now();
const updateThrottle = 2000; // 2 seconds throttle for updates
let updateTimer;

// Helper function to display a value or '----' if undefined
function displayValue(value) {
    return value === undefined ? '----' : value;
}

// Load table data from the server
function loadTableData(page, searchValue = '') {
    if (requestInProgress) return; // Prevent multiple requests
    requestInProgress = true;

    $.ajax({
        url: 'get/server_processing.php',
        type: 'POST',
        data: {
            page,
            length: recordsPerPage,
            search: searchValue,
            csrf_token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (!response.data || !Array.isArray(response.data)) {
                alert('No data found.');
                return;
            }

            const tbody = $('#inquiryTable tbody');
            const rows = response.data.map(row => `
                <tr>
                    <td>${displayValue(row.website)}</td>
                    <td>${displayValue(row.name)}</td>
                    <td>${displayValue(row.email)}</td>
                    <td>${displayValue(row.phone)}</td>
                    <td>${displayValue(row.country)}</td>
                    <td>${displayValue(row.msg)}</td>
                    <td>${displayValue(row.formatted_date)}</td>
                    <td>
                        <button class='btn btn-sm btn-danger delete-btn' data-id='${row.id}' title='Delete'>
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `).join('');

            tbody.html(rows); // Use a single update to reduce reflows

            $('#currentPageInfo').text(`Showing ${response.pagination.startRecord} to ${response.pagination.endRecord} of ${response.recordsTotal} records`);
            $('#recordInfo').show();
            totalPages = response.pagination.totalPages;
            updatePagination(totalPages);

            // Update last update time
            lastUpdate = Date.now();
        },
        error: function() {
            alert('Failed to load data. Please try again later.');
        },
        complete: function() {
            requestInProgress = false; // Allow new requests
        }
    });
}

// Check for updates based on time
function checkForUpdates() {
    if (Date.now() - lastUpdate > updateThrottle) {
        loadTableData(currentPage, $('#searchInput').val());
    }
}

// Start the update checking cycle
function startUpdateCycle() {
    clearTimeout(updateTimer);
    updateTimer = setTimeout(() => {
        checkForUpdates();
        startUpdateCycle(); // Restart the cycle
    }, updateThrottle);
}

// Pagination and search functionality
function updatePagination(totalPages) {
    const pageNumbers = $('#pageNumbers');
    pageNumbers.empty();

    const maxPagesToShow = 5;
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);
    
    if (endPage - startPage < maxPagesToShow - 1) {
        startPage = Math.max(1, endPage - (maxPagesToShow - 1));
    }

    for (let i = startPage; i <= endPage; i++) {
        const activeClass = (i === currentPage) ? 'active' : '';
        const pageButton = $(`<li class="page-item ${activeClass}"><button class="page-link" data-page="${i}">${i}</button></li>`);
        pageButton.click(() => {
            currentPage = i;
            loadTableData(currentPage, $('#searchInput').val());
        });
        pageNumbers.append(pageButton);
    }

    if (totalPages > 1) {
        const lastPageButton = $(`<li class="page-item"><button class="page-link" data-page="${totalPages}">${totalPages}</button></li>`);
        lastPageButton.click(() => {
            currentPage = totalPages;
            loadTableData(currentPage, $('#searchInput').val());
        });
        pageNumbers.append(lastPageButton);
    }
}

// Pagination buttons
$('#prevPage').click(() => {
    if (currentPage > 1) {
        currentPage--;
        loadTableData(currentPage, $('#searchInput').val());
    }
});

$('#nextPage').click(() => {
    if (currentPage < totalPages) {
        currentPage++;
        loadTableData(currentPage, $('#searchInput').val());
    }
});

// Search functionality with debounce
let debounceTimer;
$('#searchInput').on('input', function() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        currentPage = 1; // Reset to the first page
        loadTableData(currentPage, $(this).val());
    }, 300);
});

// Clear search input and reload data
$('#clearButton').click(() => {
    $('#searchInput').val('');
    currentPage = 1; // Reset to the first page
    loadTableData(currentPage);
});

// Handle visibility changes
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') {
        checkForUpdates(); // Check for updates when the user returns
    } else {
        clearTimeout(updateTimer); // Stop update checks when not visible
    }
});

// Initial load on document ready
$(document).ready(() => {
    loadTableData(currentPage);
    startUpdateCycle(); // Start the update checking process
});
</script>
