<?php
// Get the file from URL parameter
$file = $_GET['file'] ?? '';

if(empty($file)){
    die("No file specified.");
}

// Build absolute path (inside public folder)
$filepath = __DIR__ . '/' . $file; // __DIR__ points to public/

// Check if file exists
if (!file_exists($filepath)) {
    die("File not found at: " . $filepath);
}

// Serve the PDF
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($file) . '"');
readfile($filepath);
exit;
