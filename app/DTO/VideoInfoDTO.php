<?php

namespace App\DTO;

class VideoInfoDTO
{
    private string $time;
    private string $creator;
    private string $uploader;
    private string $title;
    private string $thumb;
    private string $id;

    /**
     * @param string $time
     * @param string $creator
     * @param string $uploader
     * @param string $title
     * @param string $thumb
     */
    public function __construct(string $id, string $time, string $creator, string $uploader, string $title, string $thumb)
    {
        $this->id = $id;
        $this->time = $time;
        $this->creator = $creator;
        $this->uploader = $uploader;
        $this->title = $title;
        $this->thumb = $thumb;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getCreator(): string
    {
        return $this->creator;
    }

    /**
     * @return string
     */
    public function getUploader(): string
    {
        return $this->uploader;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getThumb(): string
    {
        return $this->thumb;
    }




}
