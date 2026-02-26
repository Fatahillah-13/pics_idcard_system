<?php

$ds = DIRECTORY_SEPARATOR;  //1
$storeFolder = 'uploads';   //2
if (! empty($_FILES['file']) && isset($_FILES['file']['tmp_name']) && isset($_FILES['file']['error']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $tempFile = $_FILES['file']['tmp_name'];          //3

    // Define an allowlist of permitted file extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

    // Extract and normalize the file extension from the original name
    $originalName = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : '';
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Reject files with disallowed or missing extensions
    if ($extension === '' || ! in_array($extension, $allowedExtensions, true)) {
        http_response_code(400);
        echo 'Invalid file type.';
        exit;
    }

    // Build the target directory path
    $targetPath = dirname(__FILE__).$ds.$storeFolder.$ds;  //4

    // Ensure the upload directory exists
    if (! is_dir($targetPath)) {
        mkdir($targetPath, 0755, true);
    }

    // Generate a random filename to avoid using user-controlled paths/names
    $randomName = bin2hex(random_bytes(16)).'.'.$extension;
    $targetFile = $targetPath.$randomName;  //5

    // Only move the file if it is a valid uploaded file
    if (is_uploaded_file($tempFile)) {
        if (! move_uploaded_file($tempFile, $targetFile)) { //6
            http_response_code(500);
            echo 'Failed to save uploaded file.';
        }
    } else {
        http_response_code(400);
        echo 'Invalid upload.';
    }
}
