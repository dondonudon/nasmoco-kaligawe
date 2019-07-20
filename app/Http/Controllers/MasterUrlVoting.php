<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MasterUrlVoting extends Controller
{
    public function index() {
        $viewName = 'master_url_voting';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-master-url-survey');
        } else {
            return abort('403');
        }
    }

    public function detail() {
        $url = DB::table('sys_detail')->where('nama','=','url_survey')->get();
        return json_encode($url);
    }

    public function edit(Request $request) {
        $nama = $request->nama;
        $url = $request->info;

        $data = [
            'info' => $url,
        ];

        $dbUrl = DB::table('sys_detail')->where('nama','=',$nama);
        if ($dbUrl->update($data)) {
            $result = [
                'status' => 'success',
            ];
        } else {
            $result = [
                'status' => 'failed',
            ];
        }
        return json_encode($result);
    }
}
