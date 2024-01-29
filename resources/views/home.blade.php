@extends('components.layouts.app')

@section('content')
<div class="container w-full md:w-2/4 mx-auto p-10 bg-white rounded-3xl shadow-lg">
    <form>

        <div class="flex flex-col space-y-5">
            <div class="text-center"><h1 class="text-2xl md:text-4xl">
                    <img src="{{asset("images/direct-download.png")}}" width="50" class="inline">
                    YouTube Downloader</h1></div>

            <livewire:preload-video />

            <div class="text-sm text-slate-500">
                <p class="mb-3">{{__('To download a video from YouTube:')}}</p>
                <ul role="list" class="marker:text-sky-400 list-inside list-disc  pl-5 space-y-1">
                    <li>{{__('Copy the link to the video by clicking on the Share button in the video water')}}</li>
                    <li>{{__('Paste the resulting link into the input above')}}</li>
                    <li>{{__('Specify video or mp3 saving settings')}}</li>
                    <li>{{__('Click download to get the video')}}</li>
                    <li>{{__('You can also download videos from YouTube by simply replacing the domain www.youtube.com with :domain', ['domain' => config('app.domain')])}}</li>
                    <li>{{__('The video download link is one-time and cannot be reused')}}</li>
                </ul>
            </div>
        </div>

    </form>

</div>
@endsection
