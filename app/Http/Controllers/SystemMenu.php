<?php

namespace App\Http\Controllers;

use App\sysMenu;
use App\sysMenuGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SystemMenu extends Controller
{
    public function index() {
        $viewName = 'system_menu';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-system-menu');
        } else {
            return abort('403');
        }
    }

    public function list() {
        $menu = DB::table('sys_menu')
            ->select('sys_menu.id','sys_menu.id_group','sys_menu_group.nama AS nama_group','sys_menu.nama','url','view_name','sys_menu.ord')
            ->join('sys_menu_group','sys_menu.id_group','=','sys_menu_group.id')
            ->get();
        $result = array(
            'data' => $menu
        );
        return json_encode($result);
    }

    public function group() {
        $result = sysMenuGroup::all();
        return json_encode($result);
    }

    public function add(Request $request) {
        $data = [
            'id_group' => $request->id_group,
            'nama' => $request->nama,
            'url' => $request->url,
            'view_name' => $request->view_name,
            'ord' => $request->order,
        ];

        $group = DB::table('sys_menu');
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
            'id_group' => $request->id_group,
            'nama' => $request->nama,
            'url' => $request->url,
            'view_name' => $request->view_name,
            'order' => $request->order,
        ];

        $group = DB::table('sys_menu')->where('id','=',$id);
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
