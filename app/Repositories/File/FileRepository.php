<?php
namespace App\Repositories\File;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;

use Carbon\Carbon;
use App\File;
use DB;

class FileRepository implements IFileRepository {
    /**
     * {@inheritdoc}
     */
    public function uploadOne($folder, UploadedFile $fileUpload, $fileableType = null, $fileableId = null) {
        $path = Storage::disk(env('DISK_TYPE'))
            ->putFile($folder, $fileUpload, env('DISK_TYPE_VISIBILITY'));

        return File::create([
            'name' => $fileUpload->getClientOriginalName(),
            'path' => $path,
            'folder' => $folder,
            'extension' => $fileUpload->getClientOriginalExtension(),
            'disk_type' => env('DISK_TYPE'),
            'visibility' => env('DISK_TYPE_VISIBILITY'),
            'fileable_type' => $fileableType,
            'fileable_id' => $fileableId
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function uploadMultiple($folder, array $files, $fileableType = null, $fileableId = null) {
        if ($folder == null)
            $folder = 'temp';

        $fileData = [];

        foreach ($files as $file) {
            $path = Storage::disk(env('DISK_TYPE'))
                ->putFile($folder, $file, env('DISK_TYPE_VISIBILITY'));
            
            array_push($fileData, [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'folder' => $folder,
                'extension' => $file->getClientOriginalExtension(),
                'disk_type' => env('DISK_TYPE'),
                'visibility' => env('DISK_TYPE_VISIBILITY')
            ]);
        }

        $files = [];
        DB::beginTransaction();
        foreach ($fileData as $file) {
            array_push($files, File::create($file));
        }
        DB::commit();

        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function clear_old_files($days) {
        $query = File::where('created_at', '<=', Carbon::now()->subDays($days)->toDateTimeString())
            ->where('fileable_type', null)
            ->where('fileable_id', null);

        $files = $query->get();

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        
        foreach ($files as $file) {
            $output->writeln('<info> Deleting file ['.$file->name.']...</info>');
            Storage::disk($file->disk_type)
                ->delete($file->path);
        }

        $query->delete();
    }
}