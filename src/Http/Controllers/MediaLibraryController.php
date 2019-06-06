<?php

namespace Mdixon18\MediaLibrary\Http\Controllers;

use Illuminate\Routing\Controller;
use Mdixon18\MediaLibrary\Models\Media;

class MediaLibraryController extends Controller 
{
    public function media()
    {
        $media = Media::where('collection_name', request('type', 'images'));

        if (request('search') && filled(request('search'))) {
            $search = request('search');
            $media->where(function($q) use($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%")
                    ->orWhere('mime_type', 'like', "%{$search}%")
                    ->orWhere('alt_text', 'like', "%{$search}%")
                    ->orWhere('caption', 'like', "%{$search}%");
            });
        }

        $media = $media->orderBy('order_column', 'desc')->orderBy('created_at', 'desc')->paginate(request('pcount', 32));

        if (!$media->isEmpty()) {
            foreach ($media as &$m) {
                $m->url = $m->getUrl();
                $m->fullUrl = $m->getFullUrl();
                $m->downloadUrl = $m->downloadUrl();
                $m->humanSize = $m->getHumanReadableSizeAttribute();

                if (request('type', 'images') == 'images') {
                    $image = $m->image();
                    $m->image = [
                        'width'  => $image->getWidth(),
                        'height' => $image->getHeight()
                    ];
                }
                
            }
        }

        return response()->json([
            'media' => $media->getCollection(),
            'total' => $media->total()
        ]);
    }

    public function save()
    {
        if (request('id')) {
            $media = Media::where('id', request('id'))->first();
            if ($media) {
                $media->update([
                    'alt_text' => request('alt_text', null),
                    'caption' => request('caption', null),
                ]);
            }

            return response()->json(['message' => 'The files information has been updated.']);
        }

        return response([], 500);
    }

    public function delete()
    {
        if (request('items')) {
            $medias = Media::whereIn('id', request('items'))->get();
            if (!$medias->isEmpty()) {
                foreach ($medias as $media) {
                    $media->delete();
                }
            }

            return response()->json(['message' => 'The selected file(s) have been deleted.']);
        }

        return response([], 500);
    }

    public function upload()
    {
        try {
            $media = Media::addFromRequest('file')
                    ->sanitizingFileName(function($fileName) {
                        return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                    });

            if (exif_imagetype( request('file') )) {
                $media->withResponsiveImages()
                    ->preservingOriginal();
            }
                        
            $media->toMediaCollection(exif_imagetype( request('file') ) ? 'images' : 'files');

            return response()->json(['message' => "The ".request('file')->getClientOriginalName()." file has been uploaded."]);
        } catch (\Throwable $e) {
            return response(['message' => $e->getMessage()], 500);
        }

        return response(['message' => 'Unable to upload at this time.'], 500);
    }

    public function download(Media $mediaItem)
    {
        return response()->download($mediaItem->getPath(), $mediaItem->file_name);
    }
}