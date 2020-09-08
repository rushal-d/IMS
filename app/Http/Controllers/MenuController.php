<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['permissions'] = Permission::orderBy('name', 'ASC')->get();
        $data['menu_ids'] = Menu::pluck('id')->toArray();
        $data['menus'] = Menu::rootMenu()->get();
        $data['title'] = 'All Menus';
        return view('entrust.menu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $permission = Permission::where('name','like','%'.$request->search.'%')->orderBy('name', 'ASC')->get();
        $menus = Menu::pluck('id')->toArray();
        return response()->json(['permission' => $permission, 'menu' => $menus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::all();
        $menu = Menu::create($input);
        return response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $menu = Menu::find($id);
        $menu->delete();
        return response()->json('success');
    }

    public function buildMenu(Request $request)
    {
        $p_order = 1;
        $i = 1;
        foreach ($request->menu as $menu) {
            $i++;
            if ($menu['parent_id'] == null) {
                $i = 1;
                $p_order++;
                $parent_id = null;
            } else {
                $parent_id = $menu['parent_id'];
            }
            if (isset($menu['item_id'])) {
                $new_menu = Menu::find($menu['item_id']);
                if ($menu['parent_id'] == null) {
                    $new_menu->order = $p_order;
                } else {
                    $new_menu->order = $i;
                }

                $new_menu->parent_id = $parent_id;
                $new_menu->save();
            }
        }
        $data = [];
        $data['sucess'] = 1;
        return response()->json($data);
    }
    public function displayNameStore(Request $request){
        $values = $request->permission;

        foreach ($values as $key => $value) {
            $new_menu = Menu::where('menu_name', $key)->first();
            if(!empty($new_menu)){
                $new_menu->icon = $value['icon'];
                $new_menu->display_name = $value['display_name'];
                $new_menu->update();
            }
        }
        return redirect()->back();
    }

    public function sendMenuToKB(){
        $baseUrl = Config::get('constants.kb_url');
        $menus = Menu::get();
        $data['menus'] = $menus->toArray();
        //set POST variables
        $url = $baseUrl . '/api/update-menu/investment-management-system';
        $fields_string = json_encode($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute post
        $result = curl_exec($ch);

//close connection
        curl_close($ch);
        if ($result) {
            echo 'Data Send Successfully!';
            die();
        } else {
            echo 'Something Went Wrong!';
            die();
        }
    }

    public function getMenu(){
        $baseUrl = Config::get('constants.kb_url');
        $url = $baseUrl . '/api/get-menu/investment-management-system';
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $response = json_decode($response, true);
        $status = false;
        try {
            DB::beginTransaction();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('menus')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $menusBulk = $response['menus'];
            foreach ($menusBulk as $key => $v) {
                $menusBulk[$key] ['id'] = $menusBulk[$key] ['menu_id'];
                unset($menusBulk[$key]['menu_id']);
                unset($menusBulk[$key]['project_id']);
            }
            Menu::insert($menusBulk);
            $status = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $status = false;
        }
        if ($status) {
            DB::commit();
        }
        if ($status) {
            echo 'Data Updated Successfully!';
            die();
        } else {
            echo 'Something Went Wrong!';
            die();
        }
    }
}
