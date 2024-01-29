<div>
<form wire:submit="save">
        <div>
            <div class="flex flex-row min-h-32 my-3">
                <div class="basis-1/2">
                    <div class="w-full block rounded-xl border bg-slate-50 border-slate-100 min-h-full">
                        <img src="{{$info['thumb']}}" alt="{{$info['title']}}" class="object-cover min-h-full rounded-xl">
                    </div>
                </div>
                <div class="basis-1/2 pl-3">
                    <h1 class="text-xl text-slate-900 mb-5">{{$info['title']}}</h1>
                    <div class="block mx-auto mb-5">
                        <x-bxs-time class="w-6 h-6 inline fill-slate-300"  /> {{$info['time']}}
                    </div>
                    <div class="block mx-auto mb-5">
                        <label for="file_format" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            <x-bxs-file-blank class="w-6 h-6 inline fill-slate-300"  /> {{__('File Format')}}</label>
                        <select name="file_format" wire:model="file_format" id="file_format" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ">
                            <option value="480">MP4 480p</option>
                            <option value="720">MP4 720p</option>
                            <option value="1080">MP4 1080p</option>
                            <option value="1440">MP4 2k</option>
                            <option value="2160">MP4 4k</option>
                            <option value="mp3">MP3</option>
                        </select>
                        @error('file_format')
                        @include('parts.error', ['message' => $message])
                        @enderror
                    </div>
                    <div class="block mx-auto">
                        <div class="flex flex-row">
                            <div class="basis-1/2" wire:ignore>
                                <label for="time_from" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    <x-bxs-arrow-to-left class="w-6 h-6 inline fill-slate-300" /> {{__('Start from')}}</label>
                                <input type="text" wire:model="time_from" id="time_from" name="time_from"  value="0:0:0" class="bg-gray-50 border @error('time_from') border-rose-600 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="00:00:00">
                            </div>
                            <div class="basis-1/2 pl-1" wire:ignore>
                                <label for="time_to" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    <x-bxs-arrow-to-right class="w-6 h-6 inline fill-slate-300" /> {{__('End till')}}</label>
                                <input type="text" wire:model="time_to" id="time_to"  name="time_to" value="{{$time_to}}" class="bg-gray-50 border  @error('time_to') border-rose-600 @else border-gray-300 @enderror text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="01:00:00">

                            </div>
                        </div>
                        <div wire:loading.remove>
                        @error('time_from')
                        @include('parts.error', ['message' => $message])
                        @enderror
                        @error('time_to')
                        @include('parts.error', ['message' => $message])
                        @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="
        bg-gradient-to-r
        from-purple-500
        to-pink-500
        hover:bg-gradient-to-l
        text-white
        shadow-md
        w-full
        h-14
        font-sans
        text-3xl
        rounded-lg
        mt-1
        "
        >
            <div wire:loading wire:target="save">
                <img src="{{asset('images/loader.svg')}}" width="30" class="inline-block"> {{__('Download the video...')}}
            </div>
            <div wire:loading.remove wire:target="save" id="save-text">
                {{__('Download')}}
            </div>
        </button>

        @if (session('error-save'))
            @include('parts.error', ['message' => session('error-save')])
        @endif
</form>
@script
<script>
    $(document).ready(function () {

        $('#time_from').change(function(e) {
            @this.set('time_from', $(this).val())
        })
        $('#time_to').change(function(e) {
            @this.set('time_to', $(this).val())
        })

        $('#time_from').timepicker({
            timeFormat: 'HH:mm:ss',
            setTime: '00:00:00',
            maxTime: $('#time_to').val(),
            dynamic: false,
            dropdown: true,
            interval: 1,
            scrollbar: true,
            showNowButton:false,
        });
        $('#time_to').timepicker({
            timeFormat: 'HH:mm:ss',
            maxTime: '{{$time_to}}',
            dynamic: false,
            dropdown: true,
            interval: 1,
            scrollbar: true,
            showNowButton:false,
        });
    });
</script>
@endscript
</div>
