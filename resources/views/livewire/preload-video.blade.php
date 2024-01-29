<div>
    <form id="check-form" wire:submit="check">
        <input type="text" name="url" wire:model.blur="url"  autofocus class="
                w-full h-12 font-sans rounded-lg border-2 border-pink-600 shadow-md
                disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none
                invalid:border-pink-500 invalid:text-pink-600
                placeholder:text-slate-400
                text-xl
                md:text-3xl
                py-5
                md:py-7
                px-1
                md:px-3
      " placeholder="{{__('Insert link to youtube video')}}">
        <div>
            @error('url')
            @include('parts.error', ['message' => $message])
            @enderror

            @if (session('error'))
            @include('parts.error', ['message' => session('error')])
            @endif
        </div>
        <span id="show-loading" wire:loading wire:target="url" class="block w-full h-52 place-content-center text-center text-slate-400 py-8">
            <div>
            <img src="{{asset('images/loader.svg')}}" width="40" class="inline-block"> {{__('Getting the video...')}}
                </div>
        </span>
    </form>
    @if ($fileInfo)
        <div wire:loading.remove wire:target="url">
     <livewire:save-video :info="$fileInfo" />
        </div>
    @endif

    @script
    <script>
        $wire.on('update-info', () => {
            console.log('update-info');
            $('#show-loading').show();
        });
        $wire.on('video-checked', () => {
            console.log('video-checked');
        });
        $wire.on('video-saved', () => {
            console.log('video-saved');
        });

    </script>
    @endscript
</div>
