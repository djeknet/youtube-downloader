<?php


use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VideoInfoTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test()
    {

        $service = app(\App\Services\YoutubeService::class);

        $result = $service->getVideoInfo("oSX6eKmcmWM");

        $this->assertTrue(true);

        dd($result);
    }
}
