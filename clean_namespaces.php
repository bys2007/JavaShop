<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('d:/laragon/www/javashop/app/Filament/Resources'));
foreach ($dir as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $updated = preg_replace('/(\\\\?Filament\\\\)+/', '\\\\Filament\\\\', $content);
        if ($updated !== $content) {
            file_put_contents($file->getPathname(), $updated);
            echo 'Fixed duplicated slashes in ' . $file->getFilename() . PHP_EOL;
        }
    }
}
echo "Clean up done.\n";
