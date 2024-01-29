<?php

namespace App\DTO;



class FileDTO
{
    private string $path;
    private int $size;
    private ?string $ext;
    private ?string $thumb;
    private ?string $title;

    /**
     * @param string $path
     * @param string $size
     * @param string|null $ext
     */
    public function __construct(string $path, int $size, ?string $title, ?string $ext, ?string $thumb = null)
    {
        $this->path = $path;
        $this->size = $size;
        $this->ext = $ext;
        $this->thumb = $thumb;
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }


    /**
     * @return string|null
     */
    public function getThumb(): ?string
    {
        return $this->thumb;
    }


    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string|null
     */
    public function getExt(): ?string
    {
        return $this->ext;
    }


}
