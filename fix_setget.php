<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('d:/laragon/www/javashop/app/Filament/Resources'));
$replacements = [
    'Forms\Set' => '\Filament\Schemas\Components\Utilities\Set',
    'Forms\Get' => '\Filament\Schemas\Components\Utilities\Get',
];
foreach ($dir as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $updated = str_replace(array_keys($replacements), array_values($replacements), $content);
        if ($updated !== $content) {
            file_put_contents($file->getPathname(), $updated);
            echo 'Fixed Set/Get namespaces in ' . $file->getFilename() . PHP_EOL;
        }
    }
}
echo "Done replacing Set/Get namespaces.\n";
