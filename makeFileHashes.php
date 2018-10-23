<?php
$hashes = array();
$files = array();

$files = glob("./*.php");
$files = array_merge($files, glob("./Data/*.php"));
$files = array_merge($files, glob("./Data/*/*.php"));
$files = array_merge($files, glob("./Data/*/*/*.php"));
$files = array_merge($files, glob("./Data/*/*/*/*.php"));
$files = array_merge($files, glob("./Data/*/*/*/*/*.php"));

foreach ($files as $file) {
    $hashes[$file] = md5(file_get_contents($file));
}

echo json_encode($hashes);
file_put_contents("./Data/integrityHashes.db", gzcompress(json_encode($hashes), 9));
