<?php
header('Content-Type: application/json');

$connection = mysqli_connect('localhost', 'root', 'root', 'artiscape');
if (mysqli_connect_errno()) {
    echo json_encode(['error' => 'Failed to connect to MySQL: ' . mysqli_connect_error()]);
    exit();
}

$categoryId = isset($_GET['category']) ? $_GET['category'] : '';

if (!empty($categoryId)) {
    // SQL to get designers who match the selected category
    $query = "SELECT designer.id, designer.brandName, designer.logoImgFileName, GROUP_CONCAT(designcategory.category SEPARATOR ', ') AS categories
              FROM designer
              JOIN designspeciality ON designer.id = designspeciality.designerID
              JOIN designcategory ON designspeciality.designCategoryID = designcategory.id
              WHERE designcategory.id = ?
              GROUP BY designer.id";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    // SQL to get all designers if no category is selected
    $query = "SELECT designer.id, designer.brandName, designer.logoImgFileName, GROUP_CONCAT(designcategory.category SEPARATOR ', ') AS categories
              FROM designer
              JOIN designspeciality ON designer.id = designspeciality.designerID
              JOIN designcategory ON designspeciality.designCategoryID = designcategory.id
              GROUP BY designer.id";
    $result = mysqli_query($connection, $query);
}

$designers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $designers[] = array(
        'id' => $row['id'],
        'brandName' => $row['brandName'],
        'logoImgFileName' => 'images/' . $row['logoImgFileName'],
        'category' => $row['categories']
    );
}

echo json_encode($designers);

mysqli_close($connection);
?>
