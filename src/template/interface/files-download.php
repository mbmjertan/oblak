<?php
$file = $fileData['filePath'];

$fileMimetype = $oblak->filterMimetype($fileData['mimetype']);

$quoted = sprintf('"%s"', addcslashes($fileData['name'], '"\\'));
$size = $fileData['size'];


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . $quoted);
header('Content-Transfer-Encoding: chunked');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $size);
readfile($fileData['filePath']);

