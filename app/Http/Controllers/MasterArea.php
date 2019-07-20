<?php

namespace App\Http\Controllers;

use App\msArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MasterArea extends Controller
{
    public function index() {
        $viewName = 'master_area';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-master-area');
        } else {
            return abort('403');
        }
    }

    public function list() {
        $area['data'] = msArea::all();

        return json_encode($area);
    }

    public function add(Request $request) {
        $nama = $request->nama;

        $area = new msArea;
        $area->nama = $nama;

        if ($area->save()) {
            $result = [
                'status' => 'success'
            ];
        } else {
            $result = [
                'status' => 'failed'
            ];
        }
        return json_encode($result);
    }
}
