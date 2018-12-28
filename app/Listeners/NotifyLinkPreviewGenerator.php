<?php

namespace App\Listeners;

use App\Events\LinkCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Preview;

class NotifyLinkPreviewGenerator
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LinkCreated  $event
     * @return void
     */
    public function handle(LinkCreated $event)
    {
        $link = $event->link;
        $previewClient = Preview::setUrl($link->url);
        // Get a preview from specific parser
        $preview = $previewClient->getPreview('general');
        // Convert output to array
        $preview = $preview->toArray();
        // Update Link
        $link->cover = $preview['cover'];
        $link->title = $preview['title'];
        $link->description = $preview['description'];
        $link->save();
    }
}
