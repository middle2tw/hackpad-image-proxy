<?php

if (!preg_match('#http://s3.amazonaws.com/hackpad-profile-photos/([^@]*@[^%]*)#', $_SERVER['REQUEST_URI'], $matches)) {
    die("unknown url " . htmlspecialchars($_SERVER['REQUEST_URI']) . ", source: https://github.com/middle2tw/hackpad-image-proxy");
}

$obj = json_decode(file_get_contents('http://picasaweb.google.com/data/entry/api/user/' . $matches[1] . '?alt=json'));
if (!$obj or !property_exists($obj->entry, 'gphoto$thumbnail') or !property_exists($obj->entry->{'gphoto$thumbnail'}, '$t')) {
    die("unknown url, source: https://github.com/middle2tw/hackpad-image-proxy");
}
header('Content-Type: image/jpeg');
header('Cache-Control: max-age=86400');
echo file_get_contents($obj->entry->{'gphoto$thumbnail'}->{'$t'});
