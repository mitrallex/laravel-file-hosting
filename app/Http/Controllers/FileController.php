<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App;
use App\File;

class FileController extends Controller
{
    private $image_ext = ['jpg', 'jpeg', 'png', 'gif'];
    private $audio_ext = ['mp3', 'ogg'];
    private $video_ext = ['mp4', 'mpeg'];
    private $document_ext = ['doc', 'docx', 'pdf', 'odt'];

    public function fetchFile($type, $id = null)
    {
        $model = new File();

        if (!is_null($id)) {
            $files = $model::findOrFail($id);
        } else {
            $files = $model::where('type', $type)
                            ->where('user_id', Auth::id())
                            ->orderBy('id', 'desc')->get();
        }

        return json_encode($files);
    }

    public function addFile(Request $request)
    {
        $model = new File();

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $type = $this->getType($ext);

        $user_dir = Auth::user()->name . '_' . Auth::id();

        Storage::putFileAs('/public/' . $user_dir . '/' . $type . '/', $file, $request['name'] . '.' . $ext);

        return $model::create([
                'name' => $request['name'],
                'type' => $type,
                'extension' => $ext,
                'user_id' => Auth::id()
            ]);
    }

    public function deleteFile($id)
    {
        $file = File::findOrFail($id);
        $user_dir = Auth::user()->name . '_' . Auth::id();
        if (Storage::disk('local')->exists('/public/' . $user_dir . '/' . $file->type . '/' . $file->name . '.' . $file->extension)) {
            Storage::disk('local')->delete('/public/' . $user_dir . '/' . $file->type . '/' . $file->name . '.' . $file->extension);
        }
        $file->delete();
    }

    private function getType($ext)
    {
        if (in_array($ext, $this->image_ext)) {
            return 'image';
        }

        if (in_array($ext, $this->audio_ext)) {
            return 'audio';
        }

        if (in_array($ext, $this->video_ext)) {
            return 'video';
        }
        
        if (in_array($ext, $this->document_ext)) {
            return 'document';
        }
    }
}
