<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\PaginationResource;
use Validator;

class UserController extends Controller
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
            'name',
            'email'
        ];
        if($request->has('filterBy') 
            && $request->has('filterValue') 
            && in_array($request->query('filterBy'), $allowedFilters)) {
                
            $users = User::where($request->query('filterBy'), 'LIKE', '%'.$request->query('filterValue').'%')->paginate($perPage);
            $users->appends([
                'filterBy' => $request->query('filterBy'),
                'filterValue' => $request->query('filterValue')
            ]);
            $users->withPath(url()->current().'?filterBy='.$request->query('filterBy').'&filterValue='.$request->query('filterValue'));
        } else {
            $users = User::paginate($perPage);
        }
    
        return response([
            'data' => UserResource::collection($users),
            'pagination' => new PaginationResource($users),
            'message' => 'Users retrieved successfully'
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
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => 'required|string'
        ]);

        $user = User::create($input);

        $response = [
            'data' => new UserResource($user),
            'message' => 'User created successfully'
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
        $user = User::find($id);
  
        if (is_null($user)) {
            return response([
                'message' => 'User not found'
            ], 404);
        }
   
        return response([
            'data' => new UserResource($user)
        ], 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();
        
        if(!empty($input['password'])) {
            $validator = $request->validate([
                'name' => 'required|string',
                'role' => 'required|string',
                'email' => 'required|string|unique:users,email,'.$user->id,
                'password' => 'required|string|confirmed',
            ]);
        
        } else {
            $validator = $request->validate([
                'name' => 'required|string',
                'role' => 'required|string',
                'email' => 'required|string|unique:users,email,'.$user->id,
            ]);
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->role = $input['role'];
        if(!empty($input['password']))
            $user->password = bcrypt($input['password']);
        $user->save();

        $response = [
            'data' => new UserResource($user),
            'message' => 'User updated successfully'
        ];

        return response($response, 200);
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
   
        return response([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
