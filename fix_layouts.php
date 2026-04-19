<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('d:/laragon/www/javashop/app/Filament/Resources'));
$replacements = [
    'Forms\Components\Section' => '\Filament\Schemas\Components\Section',
    'Forms\Components\Grid' => '\Filament\Schemas\Components\Grid',
    'Forms\Components\Fieldset' => '\Filament\Schemas\Components\Fieldset',
    'Forms\Components\Group' => '\Filament\Schemas\Components\Group',
    'Forms\Components\Tabs' => '\Filament\Schemas\Components\Tabs',
    'Forms\Components\Wizard' => '\Filament\Schemas\Components\Wizard',
    'Infolists\Components\Section' => '\Filament\Schemas\Components\Section',
    'Infolists\Components\Grid' => '\Filament\Schemas\Components\Grid',
    'Infolists\Components\Fieldset' => '\Filament\Schemas\Components\Fieldset',
    'Infolists\Components\Group' => '\Filament\Schemas\Components\Group',
    'Infolists\Components\Tabs' => '\Filament\Schemas\Components\Tabs',
    'Infolists\Components\Wizard' => '\Filament\Schemas\Components\Wizard',
];
foreach ($dir as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $updated = str_replace(array_keys($replacements), array_values($replacements), $content);
        if ($updated !== $content) {
            file_put_contents($file->getPathname(), $updated);
            echo 'Fixed layout namespaces in ' . $file->getFilename() . PHP_EOL;
        }
    }
}
echo "Done replacing layout namespaces.\n";
