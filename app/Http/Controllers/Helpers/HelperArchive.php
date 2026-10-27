<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HelperArchive extends Controller
{
    public function renameArchiveUpload(Request $request, $column, $path='', $forceWebp=false)
    {
        !Session::has('timestampArchive')?Session::put('timestampArchive', 1):Session::put('timestampArchive', Session::get('timestampArchive')+1);
        $timestampArchive = Session::get('timestampArchive');

        $columnCrop = $column.'_cropped';
        if($request->has($columnCrop) && strpos($request->$columnCrop, ';base64')){
            //Get image base64
            $fileBase64 = explode(',', $request->$columnCrop)[1];
            // Rename file
            $nameFile = $request->$column->getClientOriginalName();
            $originalName = Str::of(pathinfo($nameFile, PATHINFO_FILENAME))->slug().'-'.(time()+$timestampArchive);
            if ($forceWebp) {
                $extension = 'webp';
            } else {
                $parts = explode('.', $nameFile);
                $extension = end($parts);
            }
            $nameFile = "{$originalName}.{$extension}";

            return [$fileBase64, $nameFile];
        }

        if ($request->hasFile($column)) {
            if(is_array($request->$column)){
                $arrNameFile = [];
                foreach ($request->$column as $key => $value) {
                    $nameFile = $request->$column[$key]->getClientOriginalName();
                    $originalName = Str::of(pathinfo($nameFile, PATHINFO_FILENAME))->slug().'-'.(time()+$timestampArchive);
                    $mime = $request->$column[$key]->getMimeType();
                    // Só força webp se não for SVG
                    if ($forceWebp && $mime !== 'image/svg+xml') {
                        $extension = 'webp';
                    } else {
                        $parts = explode('.', $nameFile);
                        $extension = end($parts);
                    }
                    $nameFile = "{$originalName}.{$extension}";
                    $request->$column[$key]->storeAs($path, "{$originalName}.{$extension}");
                    array_push($arrNameFile, "{$originalName}.{$extension}");
                    $nameFile = $arrNameFile;
                }
            }else{
                $nameFile = $request->$column->getClientOriginalName();
                $originalName = Str::of(pathinfo($nameFile, PATHINFO_FILENAME))->slug().'-'.(time()+$timestampArchive);
                $mime = $request->$column->getMimeType();
                // Só força webp se não for SVG
                if ($forceWebp && $mime !== 'image/svg+xml') {
                    $extension = 'webp';
                } else {
                    $parts = explode('.', $nameFile);
                    $extension = end($parts);
                }
                $nameFile = "{$originalName}.{$extension}";
            }

            return $nameFile;
        }else{
            return false;
        }
    }

    /**
     * Rename file for uploads
     *
     * @param Illuminate\Http\Request $request
     * @param string $column
     *
     * @return string|boolean
     */
    public function multipleUploadImage($request, $column, $path)
    {
        !Session::has('timestampArchive')?Session::put('timestampArchive', 1):Session::put('timestampArchive', Session::get('timestampArchive')+1);
        $timestampArchive = Session::get('timestampArchive');

        foreach ($request->$column as $images) {
            $arrayContent = explode('|', $images);
            $originalName = Str::of(pathinfo($arrayContent[0], PATHINFO_FILENAME))->slug().'-'.(time()+$timestampArchive);
            $arrayName = explode('.', $arrayContent[0]);
            $extension = end($arrayName);
            $nameFile = "{$originalName}.{$extension}";

            Storage::put($path.$nameFile, base64_decode($arrayContent[1]));
        }
    }
}
