<?php
use App\Models\Setting;

$logo = Setting::where('key', 'site_logo')->first();
if ($logo && str_contains($logo->value, 'http')) {
    $value = $logo->value;
    // Remove domain and storage prefix to keep only the relative path
    $value = preg_replace('/^https?:\/\/[^\/]+\/storage\//', '', $value);
    $logo->value = $value;
    $logo->save();
    echo "Updated logo path to: " . $value . "\n";
} else {
    echo "No absolute path found for logo.\n";
}
