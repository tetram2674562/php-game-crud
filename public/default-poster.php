<?php

declare(strict_types=1);

$name = 'img/default_poster.jpg';
$fp = fopen($name, 'rb');

// send the right headers
header("Content-Type: image/jpeg");
header("Content-Length: " . filesize($name));

// dump the picture and stop the script
fpassthru($fp);
