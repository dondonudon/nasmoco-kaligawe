<?php

namespace App\Http\Controllers;

use App\msVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MasterVote extends Controller
{
    public function index() {
        $viewName = 'master_vote';
        $username = Session::get('username');
        $permission = DB::table('ms_permission')
            ->join('sys_menu','ms_permission.id_menu','=','sys_menu.id')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1'],
                ['sys_menu.view_name','=',$viewName],
            ]);
        if ($permission->exists()) {
            return view('dashboard-master-vote');
        } else {
            return abort('403');
        }
    }

    public function list() {
        $result['data'] = msVote::all();

        return json_encode($result);
    }

    public function add(Request $request) {
        $nama = $request->nama;

        $vote = new msVote;
        $vote->nama = $nama;

        if ($vote->save()) {
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
        $nama = $request->nama;

        $vote = DB::table('ms_vote')->where('id','=',$id);


        if ($vote->update(['nama' => $nama])) {
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
