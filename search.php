<?php
/**
 * Animal search and filter results.
 * - Public users see only status = Available; staff/admin can filter by status.
 * - Minimal view: results only (from home search). Full view: filter form + results.
 * - Optional DB columns (location, sex, etc.) from sql/add_animal_filters_schema.sql.
 */
session_start();

if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'public';
}
$canSeeAllStatuses = in_array($_SESSION['role'], ['staff', 'admin'], true);

$conn = new mysqli("localhost", "root", "", "Eastern_Oregon_Pets_Database");
if ($conn->connect_error) {
    die("Database connection failed");
}
$conn->set_charset("utf8mb4");

// Optional columns for display (schema may not have location, sex, etc.)
$filterColumns = [];
$res = $conn->query("SHOW COLUMNS FROM animals");
while ($row = $res->fetch_assoc()) {
    $filterColumns[$row['Field']] = true;
}
$hasLocation = !empty($filterColumns['location']);
$hasSex = !empty($filterColumns['sex']);
$hasFurColor = !empty($filterColumns['fur_color']);
$hasSize = !empty($filterColumns['size']);
$hasHealthStatus = !empty($filterColumns['health_status']);

$perPage = max(10, min(50, (int)($_GET['per_page'] ?? 10)));
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

$q = trim($_GET['q'] ?? '');
$filterSpecies = trim($_GET['species'] ?? '');
$filterLocation = trim($_GET['location'] ?? '');
$filterAge = $_GET['age'] ?? '';
$filterSex = trim($_GET['sex'] ?? '');
$filterStatus = trim($_GET['status'] ?? '');

$ajax = isset($_GET['ajax']) && $_GET['ajax'] === '1';
$hasFilterParams = $filterSpecies !== '' || $filterLocation !== '' || $filterAge !== ''
    || $filterSex !== '' || ($canSeeAllStatuses && $filterStatus !== '');
$minimalView = (isset($_GET['minimal']) && $_GET['minimal'] === '1')
    || (isset($_GET['q']) && !$hasFilterParams && !isset($_GET['filters']));

$where = [];
$types = '';
$params = [];

// Public: only Available
if (!$canSeeAllStatuses) {
    $where[] = "LOWER(TRIM(status)) = 'available'";
} elseif ($filterStatus !== '') {
    $where[] = "LOWER(TRIM(status)) = LOWER(?)";
    $types .= 's';
    $params[] = $filterStatus;
}

// Text search (name, species, breed) - partial, case-insensitive
if ($q !== '') {
    $where[] = "(
        LOWER(name) LIKE LOWER(?) OR
        LOWER(COALESCE(species,'')) LIKE LOWER(?) OR
        LOWER(COALESCE(breed,'')) LIKE LOWER(?)
    )";
    $term = '%' . $q . '%';
    $types .= 'sss';
    $params[] = $term;
    $params[] = $term;
    $params[] = $term;
}

// Filters (AND logic)
if ($filterSpecies !== '') {
    $where[] = "LOWER(TRIM(COALESCE(species,''))) = LOWER(?)";
    $types .= 's';
    $params[] = $filterSpecies;
}
if ($hasLocation && $filterLocation !== '') {
    $where[] = "LOWER(COALESCE(location,'')) LIKE LOWER(?)";
    $types .= 's';
    $params[] = '%' . $filterLocation . '%';
}
if ($filterAge !== '' && is_numeric($filterAge)) {
    $where[] = "age = ?";
    $types .= 'i';
    $params[] = (int)$filterAge;
}
if ($hasSex && $filterSex !== '') {
    $where[] = "LOWER(TRIM(COALESCE(sex,''))) = LOWER(?)";
    $types .= 's';
    $params[] = $filterSex;
}

$whereSql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

// Count total for pagination
$countSql = "SELECT COUNT(*) AS total FROM animals $whereSql";
$countStmt = $conn->prepare($countSql);
if ($types !== '') {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$totalRows = (int) $countStmt->get_result()->fetch_assoc()['total'];
$countStmt->close();
$totalPages = $perPage > 0 ? (int) ceil($totalRows / $perPage) : 1;
$page = min(max(1, $page), $totalPages);
$offset = ($page - 1) * $perPage;

// Data query with pagination (only select optional columns if they exist)
$selectExtras = [];
if ($hasLocation) $selectExtras[] = "COALESCE(location,'') AS location";
if ($hasSex) $selectExtras[] = "COALESCE(sex,'') AS sex";
if ($hasFurColor) $selectExtras[] = "COALESCE(fur_color,'') AS fur_color";
if ($hasSize) $selectExtras[] = "COALESCE(size,'') AS size";
if ($hasHealthStatus) $selectExtras[] = "COALESCE(health_status,'') AS health_status";
$extraSelect = count($selectExtras) ? ', ' . implode(', ', $selectExtras) : '';
$sql = "SELECT id, name, species, breed, age, status, intake_date, image $extraSelect
        FROM animals $whereSql ORDER BY name ASC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$params[] = $perPage;
$params[] = $offset;
$stmt->bind_param($types . 'ii', ...$params);
$stmt->execute();
$result = $stmt->get_result();
$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
$stmt->close();
$conn->close();

// Persist current filters for the form and pagination links
$queryParams = [
    'q' => $q,
    'species' => $filterSpecies,
    'location' => $filterLocation,
    'age' => $filterAge,
    'sex' => $filterSex,
];
if ($canSeeAllStatuses && $filterStatus !== '') {
    $queryParams['status'] = $filterStatus;
}
if ($minimalView) {
    $queryParams['minimal'] = '1';
}
if (isset($_GET['filters']) && $_GET['filters'] === '1') {
    $queryParams['filters'] = '1';
}
$baseQuery = http_build_query(array_filter($queryParams, function ($v) { return $v !== ''; }));

function esc($s) {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

function renderResults(array $rows): string {
    $html = '';
    foreach ($rows as $row) {
        $html .= '<div class="animal-card border rounded p-3 mb-3">';
        $html .= '<h3 class="h5">' . esc($row['name']) . '</h3>';
        $html .= '<p class="mb-1">Species: ' . esc($row['species']) . '</p>';
        if (!empty($row['breed'])) {
            $html .= '<p class="mb-1">Breed: ' . esc($row['breed']) . '</p>';
        }
        if (isset($row['age']) && $row['age'] !== '') {
            $html .= '<p class="mb-1">Age: ' . esc($row['age']) . '</p>';
        }
        if (!empty($row['location'])) {
            $html .= '<p class="mb-1">Location: ' . esc($row['location']) . '</p>';
        }
        if (!empty($row['sex'])) {
            $html .= '<p class="mb-1">Sex: ' . esc($row['sex']) . '</p>';
        }
        if (!empty($row['size'])) {
            $html .= '<p class="mb-1">Size: ' . esc($row['size']) . '</p>';
        }
        if (!empty($row['fur_color'])) {
            $html .= '<p class="mb-1">Fur color: ' . esc($row['fur_color']) . '</p>';
        }
        if (!empty($row['health_status'])) {
            $html .= '<p class="mb-1">Health: ' . esc($row['health_status']) . '</p>';
        }
        if (!empty($row['image'])) {
            $imgSrc = 'animal_photos/' . esc($row['image']);
            $html .= '<img class="animal-result-image img-fluid rounded" src="' . $imgSrc . '" width="200" alt="' . esc($row['name']) . '" loading="lazy"><br>';
        }
        $html .= '<p class="mb-0 mt-1 text-muted">Status: ' . esc($row['status']) . '</p>';
        $html .= '</div>';
    }
    return $html;
}

function renderPagination(int $page, int $totalPages, string $baseQuery, int $perPage): string {
    if ($totalPages <= 1) {
        return '';
    }
    $base = 'search.php?' . $baseQuery . ($baseQuery !== '' ? '&' : '');
    $html = '<nav class="mt-3" aria-label="Results pagination"><ul class="pagination flex-wrap">';
    if ($page > 1) {
        $prev = $page - 1;
        $html .= '<li class="page-item"><a class="page-link" href="' . esc($base . 'page=' . $prev . '&per_page=' . $perPage) . '">Previous</a></li>';
    }
    for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++) {
        $active = $i === $page ? ' active' : '';
        $html .= '<li class="page-item' . $active . '"><a class="page-link" href="' . esc($base . 'page=' . $i . '&per_page=' . $perPage) . '">' . $i . '</a></li>';
    }
    if ($page < $totalPages) {
        $next = $page + 1;
        $html .= '<li class="page-item"><a class="page-link" href="' . esc($base . 'page=' . $next . '&per_page=' . $perPage) . '">Next</a></li>';
    }
    $html .= '</ul></nav>';
    return $html;
}

$resultsHtml = renderResults($rows);
$paginationHtml = renderPagination($page, $totalPages, $baseQuery, $perPage);

if ($ajax) {
    header('Content-Type: text/html; charset=utf-8');
    echo '<div id="results-meta" data-total="' . (int)$totalRows . '">' . esc($totalRows) . ' result(s)</div>' . $resultsHtml . $paginationHtml;
    exit;
}

// Full page: include layout and filter form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Search Results - Eastern Oregon Pets</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <style>
    .masthead-search { height: auto !important; min-height: 0 !important; padding-top: 5rem !important; padding-bottom: 0.25rem !important; }
    #results-section.projects-section { padding-top: 0.5rem !important; }
    </style>
</head>
<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Eastern Oregon Pets</a>
        </div>
        <div class="container px-4 px-lg-5">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#signup">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="masthead masthead-search">
        <div class="container px-4 px-lg-5">
            <?php if ($minimalView) : ?>
            <h1 class="text-white mb-2">Search Results</h1>
            <p class="text-white-50 mb-0">
                <?= (int) $totalRows ?> result(s)<?php if ($q !== '') { echo ' for “' . esc($q) . '”'; } ?>
                — <?php
                $baseQueryFull = trim(str_replace(['minimal=1&', '&minimal=1', 'minimal=1'], '', $baseQuery), '&');
                $filtersUrl = 'search.php?' . ($baseQueryFull !== '' ? esc($baseQueryFull) . '&' : '') . 'filters=1';
                ?><a href="<?= esc($filtersUrl) ?>" class="text-white">Filters</a>
            </p>
            <?php else : ?>
            <h1 class="text-white mb-3">Search &amp; Filter Animals</h1>
            <form action="search.php" method="get" id="filter-form" class="filter-form">
                <input type="hidden" name="page" value="1" />
                <input type="hidden" name="filters" value="1" />
                <div class="row g-2 align-items-end flex-wrap">
                    <div class="col-12 col-md-6 col-lg-2">
                        <label class="form-label text-white small mb-0">Search</label>
                        <input type="search" class="form-control form-control-sm" name="q" placeholder="Name, species" value="<?= esc($q) ?>" aria-label="Search text">
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <label class="form-label text-white small mb-0">Species</label>
                        <input type="text" class="form-control form-control-sm" name="species" placeholder="Species" value="<?= esc($filterSpecies) ?>" aria-label="Species">
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <label class="form-label text-white small mb-0">Location</label>
                        <input type="text" class="form-control form-control-sm" name="location" placeholder="Location" value="<?= esc($filterLocation) ?>" aria-label="Location">
                    </div>
                    <div class="col-12 col-md-6 col-lg-1">
                        <label class="form-label text-white small mb-0">Age</label>
                        <input type="number" class="form-control form-control-sm" name="age" placeholder="Age" value="<?= esc($filterAge) ?>" min="0" max="99" aria-label="Age">
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <label class="form-label text-white small mb-0">Sex</label>
                        <input type="text" class="form-control form-control-sm" name="sex" placeholder="Sex" value="<?= esc($filterSex) ?>" aria-label="Sex">
                    </div>
                    <?php if ($canSeeAllStatuses) : ?>
                    <div class="col-12 col-md-6 col-lg-2">
                        <label class="form-label text-white small mb-0">Status</label>
                        <input type="text" class="form-control form-control-sm" name="status" placeholder="e.g. Available" value="<?= esc($filterStatus) ?>" aria-label="Status">
                    </div>
                    <?php endif; ?>
                    <div class="col-12 col-md-6 col-lg-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill me-1">Apply</button>
                        <a href="search.php" class="btn btn-outline-light btn-sm rounded-pill">Clear Filters</a>
                    </div>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </header>

    <section class="projects-section bg-light" id="results-section">
        <div class="container px-4 px-lg-5">
            <p class="text-muted mb-2" id="results-count"><?= esc((string) $totalRows) ?> result(s)</p>
            <div id="results-container">
                <?php echo $resultsHtml; ?>
            </div>
            <div id="pagination-container">
                <?php echo $paginationHtml; ?>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
    (function() {
        // AJAX filter form: update results without full page reload; hide images on slow connections
        var form = document.getElementById('filter-form');
        var resultsContainer = document.getElementById('results-container');
        var paginationContainer = document.getElementById('pagination-container');
        if (!form || !resultsContainer) return;

        function getFormQuery() {
            var data = new FormData(form);
            var params = [];
            data.forEach(function(v, k) {
                if (v !== '' || k === 'q') params.push(encodeURIComponent(k) + '=' + encodeURIComponent(v));
            });
            return params.join('&');
        }

        function hideImagesOnSlowConnection(container) {
            var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
            if (conn && conn.effectiveType && conn.effectiveType !== '4g') {
                (container || document).querySelectorAll('.animal-result-image').forEach(function(img) {
                    img.setAttribute('data-skip-load', '1');
                    img.removeAttribute('src');
                });
            }
        }

        form.addEventListener('submit', function(ev) {
            ev.preventDefault();
            var query = getFormQuery();
            var url = 'search.php?' + query + '&ajax=1';
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(r) { return r.text(); })
                .then(function(html) {
                    var div = document.createElement('div');
                    div.innerHTML = html;
                    var meta = div.querySelector('#results-meta');
                    if (meta) {
                        var countEl = document.getElementById('results-count');
                        if (countEl) countEl.textContent = meta.getAttribute('data-total') + ' result(s)';
                    }
                    var cards = div.querySelectorAll('.animal-card');
                    var nav = div.querySelector('nav');
                    resultsContainer.innerHTML = '';
                    cards.forEach(function(el) { resultsContainer.appendChild(el); });
                    if (paginationContainer) {
                        paginationContainer.innerHTML = nav ? nav.outerHTML : '';
                    }
                    hideImagesOnSlowConnection(resultsContainer);
                    window.history.replaceState({}, '', 'search.php?' + query);
                })
                .catch(function() {
                    form.submit();
                });
        });

        hideImagesOnSlowConnection();
    })();
    </script>
</body>
</html>
