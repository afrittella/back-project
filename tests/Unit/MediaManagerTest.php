<?php
namespace Tests\Unit;

use Tests\Testcase;

use Afrittella\BackProject\Facades\MediaManager;

class MediaManagerTest extends TestCase
{
    public function testHashName()
    {
        $file = 'random.jpg';

        $newName = MediaManager::hashName($file);

        $this->assertRegExp('/.*\.jpg/', $newName);
    }

    public function testGetCachedImageUrl()
    {
        $this->assertEquals('/'.config('imagecache.route').'/original/file.jpg', MediaManager::getCachedImageUrl('empty', 'file.jpg'));
    }
}