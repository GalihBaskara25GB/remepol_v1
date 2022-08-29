<?php

namespace App\Http\Controllers\Api;

use App\Models\Evaluation;
use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluationResource;
use App\Http\Resources\AlternatifResource;
use App\Http\Resources\KriteriaResource;
use Validator;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allowedFilters = [
            'matapelajaran_id'
        ];
        $alternatifs = [];
        $evaluations = [];
        $kriterias = KriteriaResource::collection(Kriteria::all());

        if($request->has('filterBy') 
            && $request->has('filterValue') 
            && in_array($request->query('filterBy'), $allowedFilters)) {
                
            $alternatifs = Alternatif::where($request->query('filterBy'), '=', $request->query('filterValue'))->get();
            $alternatifs = AlternatifResource::collection($alternatifs);
                
            $evaluations = Evaluation::whereHas('alternatif', function($q) use ($request) {
                $q->where($request->query('filterBy'), '=', $request->query('filterValue'));
            })->get();
            $evaluations = EvaluationResource::collection($evaluations);
        }
    
        return response([
            'data' => [
                'evaluations' => $evaluations,
                'alternatifs' => $alternatifs,
                'kriterias' => $kriterias,
            ],
            'message' => 'Evaluations retrieved successfully'
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
        $input = array();
        $toDelete = array();
        $formattedData = array();

        foreach ($request->all() as $keyAlternatif => $valueAlternatif) {
            foreach ($valueAlternatif as $keyKriteria => $valueEvaluation) {
                $input['alternatif_id'] = $keyAlternatif;
                $input['kriteria_id'] = $keyKriteria;
                $input['value'] = $valueEvaluation;
                $input['created_at'] = date('Y-m-d H:i:s');
                $input['updated_at'] = date('Y-m-d H:i:s');

                array_push($formattedData, $input);
                array_push($toDelete, $input['alternatif_id']);
            }
        }

        Evaluation::whereIn('alternatif_id', $toDelete)->delete();
        $evaluation = Evaluation::insert($formattedData);
        
        $response = [
            'data' => $formattedData,
            'message' => 'Evaluation created successfully'
        ];

        return response($response, 201);
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($matapelajaran_id)
    {
        //-- inisialisasi variabel array alternatif
        $alternatif = array();
        $alternatifs = Alternatif::where('matapelajaran_id', '=', $matapelajaran_id)->get();
        foreach ($alternatifs as $key) {
            $alternatif[$key->id] = $key->nama;
        }

        //-- inisialisasi variabel array kriteria dan bobot (W)
        $kriteria = array();
        $w = array();
        $kriterias = Kriteria::has('evaluations')->get();
        foreach ($kriterias as $key) {
            $kriteria[$key->id] = array(
                $key->nama,
                $key->atribut
            );
            $w[$key->id] = $key->bobot;
        }
        
        //-- inisialisasi variabel array matriks keputusan X
        $X=array();
        //-- inisialisasi variabel array nilai minimum/maximum per kriteria
        $min_j=array();
        $max_j=array();
        //-- ambil nilai dari tabel
        $evaluations = Evaluation::whereHas('alternatif', function($q) use ($matapelajaran_id) {
            $q->where('matapelajaran_id', '=', $matapelajaran_id);
        })->get();
        foreach ($evaluations as $key) {
            $j = $key->kriteria_id;
            $v = $key->value;
            $X[$key->alternatif_id][$j] = $v;
            $min_j[$j] = isset($min_j[$j]) ? ($min_j[$j] > $v ? $v : $min_j[$j]) : $v;
            $max_j[$j] = isset($max_j[$j]) ? ($max_j[$j] < $v ? $v : $max_j[$j]) : $v;
        }
        
        //-- inisialisasi variabel array matriks normalisasi R
        $R=array();
        foreach($X as $i=>$x_i){
            $R[$i]=array();
            foreach($x_i as $j=>$x_ij){
                if($kriteria[$j][1]=='cost')
                    $R[$i][$j]=$min_j[$j]/$x_ij;
                else
                    $R[$i][$j]=$x_ij/$max_j[$j];
            }
        }

        //-- inisialisasi variabel array preferensi P
        $P=array();
        foreach($R as $i=>$r_i){
            //-- inisialisasi nilai P utk alternatif ke-i
            $P[$i]=0;
            foreach($r_i as $j=>$r_ij){
                $P[$i]+=$w[$j]*$r_ij;
            }
        }

        arsort($P);

        $sawResult = array();
        foreach ($P as $key => $value) {
            array_push($sawResult, array(
                'alternatif_nama' => $alternatif[$key],
                'saw_value' => $value
            ));
        }
        return response([
            'data' => $sawResult,
            'message' => 'Evaluations retrieved successfully'
        ], 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $response = [
            'message' => 'Endpoint Not found'
        ];

        return response($response, 404);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
   
        return response([
            'message' => 'Evaluation deleted successfully'
        ], 200);
    }
    
}
