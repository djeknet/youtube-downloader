<?php

namespace App\Services;
use App\DTO\FileDTO;
use App\DTO\VideoInfoDTO;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class YoutubeService
{

    public function getAudioExec(string $path, string $id, string $start = null, string $end = null)
    {
        set_time_limit(300);
        $name = time();
        $filePath = $path.'/'.$name.'.mp3';
        $limit = null;

        if ($start && $end) {
            $limit = "--postprocessor-args \"-ss ".$start." -to ".$end."\"";
        } elseif ($start) {
            $limit = "--postprocessor-args \"-ss ".$start."\"";
        } elseif ($end) {
            $limit = "--postprocessor-args \"-to ".$end."\"";
        }

        // for Windows path
        //  $command = "\\ffmpeg\yt-dlp.exe --extract-audio --audio-format mp3 --audio-quality 3 ".$limit."  --output \"".$filePath."\" https://www.youtube.com/watch?v=".$id;
        // Unix path
        $command = "yt-dlp --extract-audio --audio-format mp3 --audio-quality 3 ".$limit."  --output \"".$filePath."\" https://www.youtube.com/watch?v=".$id;

        exec($command, $output, $result);

        if ($result != 0) {
            Log::error("Result code: $result . Output error:", $output);
            throw new \RuntimeException("Output error. Result code:". $result);
        }
        if (!is_array($output)) {
            Log::error("Output error:", $output);
            throw new \RuntimeException("Output error: ". json_encode($output, JSON_THROW_ON_ERROR) .".");
        }
        foreach ($output as $num => $text) {
            if (strpos($text, "ExtractAudio") !== false) {
                $isOk = 1;
                break;
            }
        }
        if (!isset($isOk)) {
            Log::error("Output data error: ". json_encode($output, JSON_THROW_ON_ERROR) .".");
            throw new \RuntimeException("Output data error: ". json_encode($output, JSON_THROW_ON_ERROR) .".");
        }

        if(!File::exists($filePath)) {
            Log::error("File not exists: $filePath.");
            throw new \RuntimeException("File not exists: $filePath.");
        } else {
            $size = File::size($filePath);
            $ext = File::extension($filePath);
            return new FileDTO($filePath, $size, null, $ext, null);
        }
    }

    public function getVideoInfo(string $id): ?VideoInfoDTO
    {
        // for Windows path
        //$command = "\\ffmpeg\yt-dlp.exe --skip-download --print \"%(duration>%H:%M:%S)s::%(creator)s::%(uploader)s::%(title)s\" https://www.youtube.com/watch?v=".$id;
        // Unix path
        $command = "yt-dlp --skip-download --print \"%(duration>%H:%M:%S)s::%(creator)s::%(uploader)s::%(title)s\" https://www.youtube.com/watch?v=".$id;

        exec($command, $output, $result);

        if ($result != 0) {
            Log::error(__FUNCTION__ . ". Result code: $result . Output error:", $output);
            throw new \RuntimeException("Result code: $result");
        }
        if (!is_array($output)) {
            Log::error(__FUNCTION__ . ". Output error:", $output);
            throw new \RuntimeException("Data output error");
        }

        $data = explode('::', $output[0]);
        $thumb = "https://i.ytimg.com/vi/{$id}/hqdefault.jpg";

        return new VideoInfoDTO(
            $id,
            $data[0],
            $data[1],
            $data[2],
            $data[3], //mb_convert_encoding($data[3], 'UTF-8', 'windows-1251'),
            $thumb
        );
    }

    public function getVideoExec(string $path, string $id, string $start = null, string $end = null, string $quality = null)
    {
        set_time_limit(300);
        $name = time();
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
        $filePath = $path.'/'.$name.'.mp4';

        $limit = null;
        if ($start && $end) {
            $limit = "\"-ss ".$start." -to ".$end."\"";
        } elseif ($start) {
            $limit = "\"-ss ".$start."\"";
        } elseif ($end) {
            $limit = "\"-to ".$end."\"";
        }

        if ($quality) {
            $quality = "\"best[height<=".$quality."]\"";
        } else {
            $quality = "\"best[height<=480]\"";
        }

        // for Windows Path
        //$command = "\\ffmpeg\yt-dlp.exe -o \"".$filePath."\" -f ".$quality."  --merge-output-format mp4 --external-downloader ffmpeg --external-downloader-args ffmpeg:".$limit." https://www.youtube.com/watch?v=".$id;
        // Unix path
        $command = "yt-dlp -o \"".$filePath."\" -f ".$quality." --merge-output-format mp4 --external-downloader ffmpeg --external-downloader-args ffmpeg:".$limit." https://www.youtube.com/watch?v=".$id;

        exec($command, $output, $result);

        if ($result != 0 && !File::exists($filePath)) {
            Log::error("Result code: $result . Output error:", $output);
            throw new \RuntimeException("Result error! Code: $result" );
        }
        if (!is_array($output)) {
            Log::error("Output error:", $output);
            throw new \RuntimeException("Output error!");
        }
        foreach ($output as $num => $text) {
            if (strpos($text, "Extracting URL") !== false) {
                $isOk = 1;
                break;
            }
        }
        if (!isset($isOk)) {
            Log::error("Output data error: ". json_encode($output, JSON_THROW_ON_ERROR) .".");
            throw new \RuntimeException("Output data error!");
        }
        if(!File::exists($filePath)) {
            Log::error("File not exists: $filePath.");
            throw new \RuntimeException("File not exists!");
        } else {
            $size = File::size($filePath);
            $ext = File::extension($filePath);
            return new FileDTO($filePath, $size, null, $ext, null);
        }
    }

}
