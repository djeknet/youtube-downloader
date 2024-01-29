<?php

namespace App\Livewire;

use App\Jobs\DeleteFile;
use App\Services\YoutubeService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class SaveVideo extends Component
{
    public ?string $file_format = null;
    public ?string $time_from = null;
    public ?string $time_to = null;
    public ?string $id = null;
    private YoutubeService $yt;

    #[Reactive]
    public $info;
    public function mount($info)
    {
        $this->info = $info;
        $this->file_format = '480';
        $this->time_to = $info['time'];
    }
    public function render()
    {
        return view('livewire.save-video');
    }
    public function boot(YoutubeService $yt)
    {
        $this->yt = $yt;
    }
    public function save()
    {
        $validated = Validator::make(
            [
                'file_format' => $this->file_format,
                'time_from' => $this->time_from,
                'time_to' => $this->time_to
            ],
            [
                'file_format' => 'required|string|in:480,720,1080,1440,2160,mp3',
                'time_from' => 'nullable|string|date_format:H:i:s',
                'time_to' => 'nullable|string|date_format:H:i:s|after:time_from',
            ],
            [
                'required' => __('The :attribute field is required'),
                'date_format' => __('The time is incorrect'),
                'after' => __('The end time must be greater than the start time'),
            ],
        )->validate();

        try {
            $path = Storage::path(date('Y-m-d'));
            if ($this->file_format == 'mp3') {
                $file = $this->yt->getAudioExec($path, $this->info['id'], $this->time_from, $this->time_to);
            } else {
                $file = $this->yt->getVideoExec($path, $this->info['id'], $this->time_from, $this->time_to, $this->file_format);
            }
        } catch (\Exception $exception) {
            request()->session()->flash('error-save', $exception->getMessage());
        }

        if (isset($file) && File::exists($file->getPath())) {
            DeleteFile::dispatch($file->getPath())->delay(now()->addHour());

            return response()->streamDownload(function () use ($file) {
                echo File::get($file->getPath());
            }, $this->info['title'] . "." . $file->getExt());

// Alternatively way to create temporary link, need s3 disc
//            return redirect(Storage::temporaryUrl(
//                $file->getPath(),
//                now()->addHour(),
//                [
//                    'ResponseContentType' => 'application/octet-stream',
//                    'ResponseContentDisposition' => 'attachment; filename=' . $file->getTitle() . "." . $file->getExt(),
//                ]
//            ));
        }

        request()->session()->flash('error-save', __('An error occurred while saving a file'));
    }
}
