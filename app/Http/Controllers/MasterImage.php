<?php

namespace App\Http\Controllers;

use App\msArea;
use App\msImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MasterImage extends Controller
{
    public function index() {
        $viewName = 'master_image';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-master-image');
        } else {
            return abort('403');
        }
    }

    public function list() {
//        $area = msImage::all();
        $data = DB::table('ms_image')
            ->select('ms_image.id as id','ms_area.nama','file')
            ->join('ms_area','ms_image.id_area','=','ms_area.id')
            ->get();
        $no = 1;
        $area['data'] = [];
        foreach ($data as $d) {
            $area['data'][] = [
                'id' => $d->id,
                'nama' => $d->nama,
                'file' => $d->file,
                'no' => $no,
            ];
            $no++;
        }
        return json_encode($area);
    }

    public function add(Request $request, $id_area) {
        $file = $request->file('filepond');
        $area = DB::table('ms_area')->select('nama')->where('id','=',$id_area)->first();

        $name = $area->nama.'_'.date('Y-m-d_H:i:s').'.jpg';

        $image = new msImage;
        $image->id_area = $id_area;
        $image->file = $name;
        $image->save();

        return Storage::putFileAs('public', $file, $name);

    }

    public function preview(Request $request) {
        $msImage = msImage::all();
        $result = [];
        foreach ($msImage as $img) {
            if ($request->getHttpHost() !== '127.0.0.1:8000') {
                $url = url(asset('laravel-system/storage/app/public')).'/'.$img->file;
            } else {
                $url = Storage::url($img->file);
            }
            $result[] = [
                'src' => $url,
                'w' => '1000',
                'h' => '600',
                'title' => $img->file,
            ];
        }
        return json_encode($result);
    }

    public function delete(Request $request) {
        $idFile = $request->id_file;
        $namaFIle = $request->nama_file;

        $msImage = DB::table('ms_image')->where('id','=',$idFile);

        try {
            $msImage->delete();
            Storage::delete('public/'.$namaFIle);
        } catch (\Exception $ex) {
            dd('Exception block', $ex);
        }
        $result['status'] = 'success';
        return json_encode($result);
    }
}
