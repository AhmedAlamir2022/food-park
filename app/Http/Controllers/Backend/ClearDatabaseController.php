<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ClearDatabaseController extends Controller
{
    function index()
    {
        return view('admin.clear-database.index');
    }

    function clearDB()
    {

        try {
            // wipe database
            Artisan::call('migrate:fresh');
            // Seed default data
            Artisan::call('db:seed', ['--class' => 'UserSeeder']);
            Artisan::call('db:seed', ['--class' => 'SettingSeeder']);
            // Artisan::call('db:seed', ['--class' => 'PaymentGatewaySettingSeeder']);
            Artisan::call('db:seed', ['--class' => 'SectionTitleSeeder']);
            Artisan::call('db:seed', ['--class' => 'CategorySeeder']);
            Artisan::call('db:seed', ['--class' => 'FooterInfoSeeder']);
            // Artisan::call('db:seed', ['--class' => 'FooterSocialSeeder']);

            // delete updated files
            $this->deleteFiles();

            return response(['status' => 'info', 'message' => 'Database wiped successfully!']);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    function deleteFiles(): void
    {
        $path = public_path('uploads');
        $preserveFiles = ['avatar.png', 'media_688e2ebcb9790.png', 'media_688e2ebcc3160.png', 'media_688e2ebcc69f8.png', 'media_688e31a579903.jpg', 'media_68907c9c5c87d.png', 'media_68907caf4add7.png'];

        $allFiles = File::allFiles($path);

        foreach ($allFiles as $file) {
            $filename = $file->getFilename();

            if (!in_array($filename, $preserveFiles)) {
                File::delete($file->getPathname());
            }
        }
    }
}