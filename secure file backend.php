<?php
function checkExifData($filePath) {
    if (function_exists('exif_read_data')) {
        $exif = @exif_read_data($filePath, null, true);
        if ($exif) {
            foreach ($exif as $section) {
                foreach ($section as $value) {
                    if (is_string($value) && preg_match('/<\?(php|=)/i', $value)) {
                        return true;
                    }
                }
            }
        }
    }
    return false;
}
function scanMetadataForJSorHTML($filePath) {
    $exif = @exif_read_data($filePath, null, true);

    if (!$exif) {
        return false;
    }

    foreach ($exif as $section => $data) {
        foreach ($data as $key => $val) {
            if (preg_match('/<script|<\/script>|eval\s*\(|javascript:|<iframe|<img|onerror=|onload=/i', $val)) {
                return true;
            }
        }
    }

    return false;
}


function hasEmbeddedCode($filePath) {
    $content = file_get_contents($filePath);
    $patterns = [
        '/<\?php/i',
        '/<\?/i',
        '/eval\s*\(/i',
        '/base64_decode\s*\(/i',
        '/system\s*\(/i',
        '/shell_exec\s*\(/i',
        '/passthru\s*\(/i'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content)) {
            return true;
        }
    }
    return false;
}
function hasembeddedimagetag ($filePath) {
    $content = file_get_contents($filePath);
    $pattern = '/<img.*?src=["\']data:image\/.*?["\'].*?>/is';
    return preg_match($pattern, $content);
}
function hasEmbeddedJS($filePath) {
    $content = file_get_contents($filePath);

    $patterns = [
        '/<script.*?>/is',            // <script> tags
        '/javascript:/i',            // JS URIs
        '/eval\s*\(/i',              // eval()
        '/new\s+Function\s*\(/i',    // new Function()
        '/document\.write\s*\(/i',   // document.write()
        '/window\.location/i',       // window.location
        '/<iframe.*?>/is',           // iframe tags
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content)) {
            return true;
        }
    }

    return false;
}
function hasEmbeddedCSS($filePath) {
    $content = file_get_contents($filePath);

    $patterns = [
        '/<style.*?>/is',            // <style> tags
        '/@import\s*["\'].*?["\']/i', // @import rules
        '/url\s*\(/i',               // url()
        '/expression\s*\(/i',        // expression()
        '/filter:\s*progid:/i'       // filter: progid:
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $content)) {
            return true;
        }
    }

    return false;
}
$targetDir = __DIR__ . "/uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['id-upload'])) {
    $file = $_FILES['id-upload'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo "Upload failed. Error code: " . $file['error'];
        exit;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $uploaded_file_name = strtolower(basename($file['name']));
    $char_blacklist = ["'", '"', '\\', '/', '<', '>', '&', '`', '*', '?', '|', '^', '%', '!', '@', '#', '$', '(', ')', '{', '}', '[', ']', ':', ';', '=', '+', '-', '_'];
    $char_wordblacklist = ['translate', 'select', 'insert', 'update', 'delete', 'drop', 'alter', 'create', 'exec', 'execute', 'call', 'grant', 'revoke', 'truncate', 'replace', 'show', 'use', 'set', 'declare', 'begin', 'end', 'if', 'while', 'for', 'case', 'when', 'then', 'else', 'loop', 'return', 'goto', 'continue', 'break'];

    if (preg_match('/\.p(hp|html?|har|hps|hp[3-9]|gif|hpt)$/i', $uploaded_file_name)) {
        http_response_code(400);
        echo "Invalid file extension.";
        exit;
    }

    // Only allow specific image types
    if (!preg_match('/\.(jpeg|jpg|png|gif)$/i', $uploaded_file_name)) {
        http_response_code(400);
        echo "Invalid image format.";
        exit;
    }

    foreach ($char_blacklist as $char) {
        if (strpos($uploaded_file_name, $char) !== false) {
            http_response_code(400);
            echo "Invalid characters in file name.";
            exit;
        }
    }

    foreach ($char_wordblacklist as $word) {
        if (strpos($uploaded_file_name, $word) !== false) {
            http_response_code(400);
            echo "Suspicious word found in file name.";
            exit;
        }
    }

    if (hasEmbeddedCode($file['tmp_name'])) {
        http_response_code(400);
        echo "File contains embedded code.";
        exit;
    }

    if (hasEmbeddedJS($file['tmp_name'])) {
        http_response_code(400);
        echo "File contains embedded JavaScript.";
        exit;
    }
    if (hasEmbeddedCSS($file['tmp_name'])) {
        http_response_code(400);
        echo "File contains embedded CSS.";
        exit;
    }
    if (checkExifData($file['tmp_name'])) {
        http_response_code(400);
        echo "File contains code in EXIF data.";
        exit;
    }
    if (hasembeddedimagetag($file['tmp_name'])) {
        http_response_code(400);
        echo "File contains embedded image tag.";
        exit;
    }
    if (scanMetadataForJSorHTML($file['tmp_name'])) {
        http_response_code(400);
        echo "File contains JavaScript or HTML in metadata.";
        exit;
    }
    $ext = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
    $fileName = 'id_' . date('Ymd_His') . '_' . bin2hex(random_bytes(5)) . "." . $ext;
    $destination = $targetDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        echo "Upload successful.";
    } else {
        http_response_code(500);
        echo "Failed to save file.";
    }
} else {
    http_response_code(400);
    echo "No file uploaded.";
}
?>
