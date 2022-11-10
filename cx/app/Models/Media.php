<?php

namespace App\Models;

use App\Libs\Fct;
use App\Services\MimeTypesService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $guarded = ['uuid'];

    public function getUrl($size = 'thumbnail')
    {
        return Fct::getMediaImageUrl($this->file_name, $size);
    }

    public function isImage()
    {
        return (new MimeTypesService())->isImageByMimeType($this->mime_type);
    }

    public function getFilesUrl(): string
    {
        return Fct::getMediaFileUrl($this->file_name);
    }

    public function getWebUrl()
    {
        return config('app.url') . '/media/' . $this->file_name;
    }

    public function getExtension()
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }
}
