<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VoteKepuasanPelanggan extends Controller
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
            return view('dashboard-vote-kepuasan-pelanggan');
        } else {
            return abort('403');
        }
    }

    public function list(Request $request) {
        $startDate = $request->start_date;
        $endDate = $request->end_date.' 23:50:00';

        $voteLike = DB::table('kepuasan_pelanggan')
            ->where('id_vote','=','1')
            ->whereBetween('created_at',[$startDate,$endDate])
            ->get()->count();
        $voteDislike = DB::table('kepuasan_pelanggan')
            ->where('id_vote','=','2')
            ->whereBetween('created_at',[$startDate,$endDate])
            ->get()->count();
        $voteDetail = clone DB::table('kepuasan_pelanggan')
            ->select('kepuasan_pelanggan.work_order','kepuasan_pelanggan.username','ms_vote.nama','kepuasan_pelanggan.created_at')
            ->join('ms_vote','kepuasan_pelanggan.id_vote','=','ms_vote.id')
            ->whereBetween('kepuasan_pelanggan.created_at',[$startDate,$endDate])
            ->get();

        $result = [
            'like' => $voteLike,
            'dislike' => $voteDislike,
            'detail' => $voteDetail,
        ];
        return json_encode($result);
    }
}
