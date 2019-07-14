<?php

namespace App\Http\Controllers;

use App\sysMenuGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardSidebar extends Controller
{
    public static function getAllSidebar() {
        $listSidebar = array();
        $group = sysMenuGroup::all();
        foreach ($group as $g) {
            $listMenu = array();
            $viewName = array();
            $menu = DB::table('sys_menu')
                ->select('id','nama','url','view_name')
                ->where('id_group','=',$g->id)
                ->get();
            foreach ($menu as $m) {
                $listMenu[] = array(
                    'id' => $m->id,
                    'nama' => $m->nama,
                    'url' => $m->url,
                );
                $viewName[] = $m->view_name;
            }
            $listSidebar[] = array(
                'group' => array(
                    'nama' => $g->nama,
                    'id_target' => $g->id_target,
                    'icon' => $g->icon,
                    'url' => $viewName,
                ),
                'menu' => $listMenu,
            );
        }
        return $listSidebar;
    }

    public static function getSidebar() {
        $username = Session::get('username');
        $group = DB::table('sys_menu_group')
            ->select('sys_menu_group.id','sys_menu_group.nama','sys_menu_group.id_target','sys_menu_group.icon')
            ->join('sys_menu','sys_menu_group.id','=','sys_menu.id_group')
            ->join('ms_permission','sys_menu.id','=','ms_permission.id_menu')
            ->where([
                ['ms_permission.username','=',$username],
                ['ms_permission.permission','=','1']
            ])
            ->distinct()
            ->get();
        $listSidebar = array();
        $group = sysMenuGroup::all();
        foreach ($group as $g) {
            $listMenu = array();
            $viewName = array();
            $menu = DB::table('sys_menu')
                ->select('sys_menu.id','sys_menu.nama','sys_menu.url','sys_menu.view_name')
                ->join('ms_permission','sys_menu.id','=','ms_permission.id_menu')
                ->where([
                    ['id_group','=',$g->id],
                    ['ms_permission.username','=',$username],
                    ['ms_permission.permission','=','1'],
                ])
                ->get();
            foreach ($menu as $m) {
                $listMenu[] = array(
                    'id' => $m->id,
                    'nama' => $m->nama,
                    'url' => $m->url,
                );
                $viewName[] = $m->view_name;
            }
            $listSidebar[] = array(
                'group' => array(
                    'nama' => $g->nama,
                    'id_target' => $g->id_target,
                    'icon' => $g->icon,
                    'url' => $viewName,
                ),
                'menu' => $listMenu,
            );
        }
        return $listSidebar;
    }
}
