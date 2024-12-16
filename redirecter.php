<?php
// Function to load URL mappings from the text file
function loadUrlMappings($filename = "urls.txt") {
    $mappings = [];
    if (file_exists($filename)) {
        $file = fopen($filename, "r");
        while (($line = fgets($file)) !== false) {
            $parts = preg_split('/\s+/', trim($line), 2);
            if (count($parts) === 2) {
                $mappings[$parts[0]] = $parts[1];
            }
        }
        fclose($file);
    }
    return $mappings;
}

// Get the shortcode from the URL
$requestUri = $_SERVER['REQUEST_URI']; // Full path, e.g., "/Ug4s0M"
$shortcode = trim($requestUri, "/"); // Extract the shortcode

// Load mappings and find the corresponding URL
$mappings = loadUrlMappings();
if (array_key_exists($shortcode, $mappings)) {
    $url = $mappings[$shortcode];
    // Redirect to the URL
    header("Location: $url", true, 302);
    exit;
} else {
    // Handle 404 if the shortcode is not found
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    echo "<p>The requested shortcode '$shortcode' does not exist.</p>";
}
?>
