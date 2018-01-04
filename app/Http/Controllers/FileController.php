<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;

class FileController extends Controller
{
    const IMAGE = 1;
    const AUDIO = 2;
    const VIDEO = 3;
    const DOCUMENT = 4;

    public function fetchFile($type, $id = null)
    {
        $model = new App\File();

        if (!is_null($id)) {
            $files = $model::findOrFail($id);
        } else {
            $type_id = $this->getTypeId($type);
            $files = $model::where('type_id', $type_id)->get();
        }

        return json_encode($files);
    }

    public function addFile(Request $request)
    {
        if ($request->isMethod('post')) {
            $model = new App\File();
            $model::create([
                'name' => $request['name'],
                'type_id' => 1,
                'user_id' => Auth::id()
            ]);
        }
        return redirect('/');
    }

    private function getTypeId($type)
    {
        switch ($type) {
            case 'image':
                $type_id = self::IMAGE;
                break;
            case 'audio':
                $type_id = self::AUDIO;
                break;
            case 'video':
                $type_id = self::VIDEO;
                break;
            case 'document':
                $type_id = self::DOCUMENT;
                break;
            default:
                $type_id = self::IMAGE;
                break;
        }

        return $type_id;
    }
}
