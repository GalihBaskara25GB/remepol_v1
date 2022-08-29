<?php

namespace App\Http\Controllers\Api;

use App\Models\Alternatif;
use App\Models\User;
use App\Models\Matapelajaran;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class ApiUtilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function count(Request $request)
    {
        $data = array();
        $allowedTables = [
          'users',
          'alternatifs',
          'kriterias',
          'matapelajarans',
        ];
        if ($request->has('table')) {
          if (in_array($request->query('table'), $allowedTables)) {
            $data[$request->query('table')] = DB::table($request->query('table'))::get()->count();
          }
        } else {
          foreach ($allowedTables as $key => $value) {
            $data[$value] = DB::table($value)->get()->count();
          }
        }
    
        return response([
            'data' => $data,
        ], 200);
    }
    
}
