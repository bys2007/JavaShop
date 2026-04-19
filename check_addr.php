<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$addrs = App\Models\UserAddress::latest()->take(5)->get();
foreach ($addrs as $a) {
    echo "ID:{$a->id} | lat:{$a->latitude} | lng:{$a->longitude} | city:{$a->city} | addr:{$a->address}\n";
}
