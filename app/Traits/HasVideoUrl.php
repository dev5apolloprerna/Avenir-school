<?php

namespace App\Traits;

/**
 * For models that have a `video_url` column (Slider, VideoGallery).
 * Gives you ->youtube_id, ->embed_url and ->thumbnail_url.
 */
trait HasVideoUrl
{
    public function getYoutubeIdAttribute(): ?string
    {
        $pattern = '~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{11})~';

        return preg_match($pattern, (string) $this->video_url, $m) ? $m[1] : null;
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->youtube_id) {
            return 'https://www.youtube.com/embed/' . $this->youtube_id;
        }

        if (preg_match('~vimeo\.com/(\d+)~', (string) $this->video_url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        return $this->video_url;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->youtube_id
            ? 'https://img.youtube.com/vi/' . $this->youtube_id . '/mqdefault.jpg'
            : null;
    }
}
