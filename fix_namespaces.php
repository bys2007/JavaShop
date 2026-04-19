<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('d:/laragon/www/javashop/app/Filament/Resources'));
$replacements = [
    'Tables\Actions\EditAction' => '\Filament\Actions\EditAction',
    'Tables\Actions\DeleteAction' => '\Filament\Actions\DeleteAction',
    'Tables\Actions\ReplicateAction' => '\Filament\Actions\ReplicateAction',
    'Tables\Actions\ViewAction' => '\Filament\Actions\ViewAction',
    'Tables\Actions\BulkAction' => '\Filament\Actions\BulkAction',
    'Tables\Actions\DeleteBulkAction' => '\Filament\Actions\DeleteBulkAction',
    'Tables\Actions\Action' => '\Filament\Actions\Action',
    'Actions\CreateAction' => '\Filament\Actions\CreateAction',
    'Actions\DeleteAction' => '\Filament\Actions\DeleteAction',
    'Actions\Action' => '\Filament\Actions\Action',
];
foreach ($dir as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $updated = str_replace(array_keys($replacements), array_values($replacements), $content);
        if ($updated !== $content) {
            file_put_contents($file->getPathname(), $updated);
            echo 'Fixed ' . $file->getFilename() . PHP_EOL;
        }
    }
}
echo "Done.\n";
