<?php namespace Afrittella\BackProject\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
/**
 * Class MediaManager
 * @package Afrittella\MediaManager
 */
class MediaManager {

    protected $media_path;

    public function __construct()
    {
        //@TODO implement google or s3 cloud storage support
        //if (config('filesystems.default') == 'google') {
          //  $this->media_path = Storage::disk()->getDriver()->getAdapter()->getStorageApiUri() . '/' . Storage::disk()->getDriver()->getAdapter()->getBucket()->name();
        //} else {
        //$this->media_path = Storage::disk()->getDriver()->getAdapter()->getPathPrefix();
        //}
    }

    public static function hello()
    {
        return "hello world";
    }

    /*public function getMediaPath()
    {
        return $this->media_path;
    }*/

    public function addAttachment($model)
    {
        return $model->addAttachment();
    }

    public function hashName($extension = 'jpg')
    {
        return str_random(32).'.'.$extension;
    }

    public function getCachedImageUrl($format, $name)
    {
        $format = $this->chooseFormat($format);

        return url('/'.config('imagecache.route').'/'.$format.'/'.$name);
    }

    public function getCachedImageTag($format, $image, $attributes = "")
    {
        $format = $this->chooseFormat($format);

        return '<img src="'.$this->getCachedImageUrl($format, $image->name).'" alt="'.$image->description.'" '.$attributes. '>';
    }

    protected function chooseFormat($format)
    {
        $templates = array_keys(config('imagecache.templates'));
        $format = strtolower($format);

        if (!in_array($format, $templates)) {
            $format = 'original';
        }

        return $format;
    }
}
