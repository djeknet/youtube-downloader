<?php

namespace App\Livewire;

use App\Services\YoutubeService;
use Illuminate\Http\Request;
use Livewire\Attributes\On;
use Livewire\Component;

class PreloadVideo extends Component
{
    public string $v = '';
    public ?string $url = null;
    public ?string $id = null;
    public ?array $fileInfo = null;

    private YoutubeService $yt;

    protected function queryString()
    {
        return [
            'id' => [
                'as' => 'v',
                'except' => '',
            ],
        ];
    }
    public function rules()
    {
        return [
            'url' => [
                'required',
                'string',
                'min:5',
            ],
            'v' => [
                'nullable',
                'string'
            ],
        ];
    }
    public function boot(YoutubeService $yt)
    {
        $this->yt = $yt;
    }
    public function mount(Request $request)
    {
        if ($this->url) {
            $this->id = $this->urlId($this->url);
        } elseif ($request->get('v')) {
            $this->id = $request->get('v');
            $this->dispatch('update-info');
        }
    }
    public function render()
    {
        return view('livewire.preload-video');
    }

    #[On('update-info')]
    public function updated()
    {
        $this->fileInfo = null;
        if ($this->url) {
            $this->validate();
            if ($this->id = $this->urlId($this->url)) {
                $this->v = $this->id;
            }
        }
        if ($this->id) {
            try {
                $data = $this->yt->getVideoInfo($this->id);
            } catch (\RuntimeException $e) {
                session()->flash('error', __('Error while receiving video'));
            }
            if (isset($data)) {
                $this->fileInfo['id'] = $this->id;
                $this->fileInfo['title'] = $data->getTitle();
                $this->fileInfo['thumb'] = $data->getThumb();
                $this->fileInfo['time'] = $data->getTime();
            }
        } else {
            session()->flash('error', __('The link is incorrect'));
        }
    }
    private function urlId(string $url): ?string
    {
        if (!str_contains($url, 'https://youtu.be/') && !str_contains($url, 'https://www.youtube.com/watch?v=')) {
            return null;
        }
        $str = str_replace(['https://youtu.be/', 'https://www.youtube.com/watch?v='], '', $url);
        return preg_replace('/[?&].*/', '', $str);
    }
}
