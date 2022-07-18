<?php

namespace App\Http\Controllers\Api;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KriteriaResource;
use App\Http\Resources\PaginationResource;
use Validator;

class KriteriaController extends Controller
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
            'atribut'
        ];
        if($request->has('filterBy') 
            && $request->has('filterValue') 
            && in_array($request->query('filterBy'), $allowedFilters)) {
                
            $kriterias = Kriteria::where($request->query('filterBy'), 'LIKE', '%'.$request->query('filterValue').'%')->paginate($perPage);
            $kriterias->appends([
                'filterBy' => $request->query('filterBy'),
                'filterValue' => $request->query('filterValue')
            ]);
            $kriterias->withPath(url()->current().'?filterBy='.$request->query('filterBy').'&filterValue='.$request->query('filterValue'));
        } else {
            $kriterias = Kriteria::paginate($perPage);
        }
    
        return response([
            'data' => KriteriaResource::collection($kriterias),
            'pagination' => new PaginationResource($kriterias),
            'message' => 'Kriterias retrieved successfully'
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
            'atribut' => 'required|string',
            'bobot' => 'required|numeric|between:0,100',
            'keterangan' => 'required|string'
        ]);

        if($validator->fails()){
            return response([
                'message' => array($validator->errors())
            ], 400);       
        }

        $kriteria = Kriteria::create($input);

        $response = [
            'data' => new KriteriaResource($kriteria),
            'message' => 'Kriteria created successfully'
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
        $kriteria = Kriteria::find($id);
  
        if (is_null($kriteria)) {
            return response([
                'message' => 'Kriteria not found'
            ], 404);
        }
   
        return response([
            'data' => new KriteriaResource($kriteria)
        ], 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        $input = $request->all();
   
        $validator = $request->validate([
            'nama' => 'required|string',
            'atribut' => 'required|string',
            'bobot' => 'required|numeric|between:0,100',
            'keterangan' => 'required|string'
        ]);

        if($validator->fails()){
            return response([
                'message' => array($validator->errors())
            ], 400);       
        }

        $kriteria->nama = $input['nama'];
        $kriteria->atribut = $input['atribut'];
        $kriteria->bobot = $input['bobot'];
        $kriteria->keterangan = $input['keterangan'];
        $kriteria->save();

        $response = [
            'data' => new KriteriaResource($kriteria),
            'message' => 'Kriteria updated successfully'
        ];

        return response($response, 200);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
   
        return response([
            'message' => 'Kriteria deleted successfully'
        ], 200);
    }
}
