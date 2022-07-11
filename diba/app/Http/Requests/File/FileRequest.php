<?php

namespace App\Http\Requests\File;

use App\Http\Requests\BaseRequest;

class FileRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $videoMimeType =  'video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video';
        $videoMimeType .= '/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi,';
        $imageMimeType = 'image/jpg,image/jpeg,image/png,';

        return [
            'file' => [
                'required',
                'file',
                'max:83360',
//                'mimetypes:text/csv,application/pdf,image/svg+xml,' . $videoMimeType . $imageMimeType
            ],
        ];
    }
}
