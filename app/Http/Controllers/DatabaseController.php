<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseController extends Controller
{
    public function index()
    {
        // Получим все файлы из storage/app/Laravel
        // Disk = 'local' предполагается
        $disk = 'local';
        $folder = 'Laravel';

        $files = Storage::disk($disk)->files($folder);

        // Можно отфильтровать только zip/sql:
        // $files = array_filter($files, fn($f) => Str::endsWith($f, ['.zip','.sql']));
        // Но это по желанию

        return view('databases', [
            'files' => $files,
        ]);
    }

    public function backup(Request $request)
    {

        Artisan::call('backup:run', ['--only-db' => true]);


        return redirect()->route('db.index')
            ->with('success', 'Backup completed!');
    }

    public function download(Request $request)
    {
        $disk = 'local';
        $file = $request->query('file');
        if (! $file || ! Storage::disk($disk)->exists($file)) {
            return redirect()->route('db.index')
                ->with('error','File not found!');
        }

        $filename = basename($file);
        return Storage::disk($disk)->download($file, $filename);
    }

}
