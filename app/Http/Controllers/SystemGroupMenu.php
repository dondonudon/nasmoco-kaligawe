<?php

namespace App\Http\Controllers;

use App\sysMenuGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SystemGroupMenu extends Controller
{
    public function index() {
        $viewName = 'system_menu_group';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-system-group-menu');
        } else {
            return abort('403');
        }
    }

    public function list() {
        return array(
            'data' => sysMenuGroup::all()
        );
    }

    public function add(Request $request) {
        $data = [
            'nama' => $request->nama,
            'id_target' => $request->id_target,
            'icon' => $request->icon,
            'ord' => $request->order,
        ];

        $group = DB::table('sys_menu_group');
        if ($group->insert($data)) {
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

    public function edit(Request $request) {
        $id = $request->id;
        $data = [
            'nama' => $request->nama,
            'id_target' => $request->id_target,
            'icon' => $request->icon,
            'ord' => $request->order,
        ];

        $group = DB::table('sys_menu_group')->where('id','=',$id);
        if ($group->update($data)) {
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
