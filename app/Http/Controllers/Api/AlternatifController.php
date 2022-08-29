<?php

namespace App\Http\Controllers\Api;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlternatifResource;
use App\Http\Resources\PaginationResource;
use Validator;

class AlternatifController extends Controller
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
            'nama'
        ];
        if($request->has('filterBy') 
            && $request->has('filterValue') 
            && in_array($request->query('filterBy'), $allowedFilters)) {
                
            $alternatifs = Alternatif::where($request->query('filterBy'), 'LIKE', '%'.$request->query('filterValue').'%')->paginate($perPage);
            $alternatifs->appends([
                'filterBy' => $request->query('filterBy'),
                'filterValue' => $request->query('filterValue')
            ]);
            $alternatifs->withPath(url()->current().'?filterBy='.$request->query('filterBy').'&filterValue='.$request->query('filterValue'));
        } else {
            $alternatifs = Alternatif::paginate($perPage);
        }
    
        return response([
            'data' => AlternatifResource::collection($alternatifs),
            'pagination' => new PaginationResource($alternatifs),
            'message' => 'Alternatifs retrieved successfully'
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
            'keterangan' => 'required|string',
            'matapelajaran_id' => 'required',
        ]);

        $alternatif = Alternatif::create($input);

        //also auto insert for evalutaions
        $evaluations = array();
        $toInsertEvaluation = array();
        foreach (Kriteria::all() as $key) {
            $evaluations['alternatif_id'] = $alternatif->id;
            $evaluations['kriteria_id'] = $key->id;
            $evaluations['value'] = '0';
            $evaluations['created_at'] = date('Y-m-d H:i:s');
            $evaluations['updated_at'] = date('Y-m-d H:i:s');

            array_push($toInsertEvaluation, $evaluations);
        }
        Evaluation::insert($toInsertEvaluation);

        $response = [
            'data' => new AlternatifResource($alternatif),
            'message' => 'Alternatif created successfully'
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
        $alternatif = Alternatif::find($id);
  
        if (is_null($alternatif)) {
            return response([
                'message' => 'Alternatif not found'
            ], 404);
        }
   
        return response([
            'data' => new AlternatifResource($alternatif)
        ], 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alternatif $alternatif)
    {
        $input = $request->all();
   
        $validator = $request->validate([
            'nama' => 'required|string',
            'keterangan' => 'required|string',
            'matapelajaran_id' => 'required',
        ]);

        $alternatif->nama = $input['nama'];
        $alternatif->keterangan = $input['keterangan'];
        $alternatif->matapelajaran_id = $input['matapelajaran_id'];
        $alternatif->save();

        $response = [
            'data' => new AlternatifResource($alternatif),
            'message' => 'Alternatif updated successfully'
        ];

        return response($response, 200);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alternatif $alternatif)
    {
        $alternatif->delete();
   
        return response([
            'message' => 'Alternatif deleted successfully'
        ], 200);
    }
}
