<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-temp-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old files from the temp folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::disk('public')->files('temp'); // احصل على كل الملفات في مجلد temp

        $deletedFilesCount = 0; // عداد للملفات المحذوفة

        foreach ($files as $file) {
            // الحصول على آخر تعديل كطابع زمني (timestamp) وتحويله إلى كائن Carbon
            $lastModified = Carbon::createFromTimestamp(Storage::disk('public')->lastModified($file));
            // تحقق من عمر الملف، إذا كان أقدم من 24 ساعة
            if ($lastModified->diffInMinutes(now()) > 1) {
                Storage::disk('public')->delete($file); // احذف الملف
                $deletedFilesCount++; // زيادة العداد
            }
        }

        // إخراج رسالة تفيد بعدد الملفات المحذوفة
        $this->info("Deleted $deletedFilesCount old temporary files.");
    }
}
