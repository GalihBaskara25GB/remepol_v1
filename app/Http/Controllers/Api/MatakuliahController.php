<?php

namespace App\Http\Controllers\Api;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MatakuliahResource;
use App\Http\Resources\PaginationResource;
use Validator;

class MatakuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 15;
        $allowedFilters = [
            'nama',
            'dosen'
        ];
        if($request->has('filterBy') 
            && $request->has('filterValue') 
            && in_array($request->query('filterBy'), $allowedFilters)) {
                
            $matakuliahs = Matakuliah::where($request->query('filterBy'), 'LIKE', '%'.$request->query('filterValue').'%')->paginate($perPage);
            $matakuliahs->appends([
                'filterBy' => $request->query('filterBy'),
                'filterValue' => $request->query('filterValue')
            ]);
            $matakuliahs->withPath(url()->current().'?filterBy='.$request->query('filterBy').'&filterValue='.$request->query('filterValue'));
        } else {
            $matakuliahs = Matakuliah::paginate($perPage);
        }
    
        return response([
            'data' => MatakuliahResource::collection($matakuliahs),
            'pagination' => new PaginationResource($matakuliahs),
            'message' => 'Matakuliahs retrieved successfully'
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $validator = $request->validate([
            'nama' => 'required|string',
            'dosen' => 'required|string',
            'semester' => 'required|numeric',
            'keterangan' => 'required|string'
        ]);

        if($validator->fails()){
            return response([
                'message' => array($validator->errors())
            ], 400);       
        }

        $matakuliah = Matakuliah::create($input);

        $response = [
            'data' => new MatakuliahResource($matakuliah),
            'message' => 'Matakuliah created successfully'
        ];

        return response($response, 201);
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matakuliah = Matakuliah::find($id);
  
        if (is_null($matakuliah)) {
            return response([
                'message' => 'Matakuliah not found'
            ], 404);
        }
   
        return response([
            'data' => new MatakuliahResource($matakuliah)
        ], 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matakuliah $matakuliah)
    {
        $input = $request->all();
   
        $validator = $request->validate([
            'nama' => 'required|string',
            'dosen' => 'required|string',
            'semester' => 'required|numeric',
            'keterangan' => 'required|string'
        ]);

        if($validator->fails()){
            return response([
                'message' => array($validator->errors())
            ], 400);       
        }

        $matakuliah->nama = $input['nama'];
        $matakuliah->dosen = $input['dosen'];
        $matakuliah->semester = $input['semester'];
        $matakuliah->keterangan = $input['keterangan'];
        $matakuliah->save();

        $response = [
            'data' => new MatakuliahResource($matakuliah),
            'message' => 'Matakuliah updated successfully'
        ];

        return response($response, 200);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matakuliah $matakuliah)
    {
        $matakuliah->delete();
   
        return response([
            'message' => 'Matakuliah deleted successfully'
        ], 200);
    }
}
