<?php

namespace App\Http\Controllers\Api;

use App\Models\Matapelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MatapelajaranResource;
use App\Http\Resources\PaginationResource;
use Validator;

class MatapelajaranController extends Controller
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
            'guru'
        ];
        if($request->has('filterBy') 
            && $request->has('filterValue') 
            && in_array($request->query('filterBy'), $allowedFilters)) {
                
            $matapelajarans = Matapelajaran::where($request->query('filterBy'), 'LIKE', '%'.$request->query('filterValue').'%')->paginate($perPage);
            $matapelajarans->appends([
                'filterBy' => $request->query('filterBy'),
                'filterValue' => $request->query('filterValue')
            ]);
            $matapelajarans->withPath(url()->current().'?filterBy='.$request->query('filterBy').'&filterValue='.$request->query('filterValue'));
        } else {
            $matapelajarans = Matapelajaran::paginate($perPage);
        }
    
        return response([
            'data' => MatapelajaranResource::collection($matapelajarans),
            'pagination' => new PaginationResource($matapelajarans),
            'message' => 'Matapelajarans retrieved successfully'
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
            'guru' => 'required|string',
            'semester' => 'required|numeric',
            'keterangan' => 'required|string'
        ]);

        $matapelajaran = Matapelajaran::create($input);

        $response = [
            'data' => new MatapelajaranResource($matapelajaran),
            'message' => 'Matapelajaran created successfully'
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
        $matapelajaran = Matapelajaran::find($id);
  
        if (is_null($matapelajaran)) {
            return response([
                'message' => 'Matapelajaran not found'
            ], 404);
        }
   
        return response([
            'data' => new MatapelajaranResource($matapelajaran)
        ], 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matapelajaran $matapelajaran)
    {
        $input = $request->all();
   
        $validator = $request->validate([
            'nama' => 'required|string',
            'guru' => 'required|string',
            'semester' => 'required|numeric',
            'keterangan' => 'required|string'
        ]);

        $matapelajaran->nama = $input['nama'];
        $matapelajaran->guru = $input['guru'];
        $matapelajaran->semester = $input['semester'];
        $matapelajaran->keterangan = $input['keterangan'];
        $matapelajaran->save();

        $response = [
            'data' => new MatapelajaranResource($matapelajaran),
            'message' => 'Matapelajaran updated successfully'
        ];

        return response($response, 200);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matapelajaran $matapelajaran)
    {
        $matapelajaran->delete();
   
        return response([
            'message' => 'Matapelajaran deleted successfully'
        ], 200);
    }
}
