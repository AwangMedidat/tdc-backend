<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        if ($users->count() > 0) {
            $data = [
                'status' => 200,
                'users' => $users
            ];
    
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Records Found'
            ];
    
            return response()->json($data, 404);
        }
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:100',
        ]);

        if ($validator->fails()){
            $data = [
                'status' => 422,
                'message' => $validator->errors()->all()
            ];
    
            return response()->json($data, 422);
        } else {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($user) {
                $data = [
                    'status' => 201,
                    'message' => "User Created Successfuly"
                ];
        
                return response()->json($data, 201);
            } else {
                $data = [
                    'status' => 500,
                    'message' => "Something Went Wrong"
                ];
        
                return response()->json($data, 500);
            }

        }
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            $data = [
                'status' => 200,
                'user' => $user
            ];
    
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'User Not Found'
            ];
    
            return response()->json($data, 404);
        } 
    }

    public function edit(int $id, Request $request)
    {
        $user = User::find($id);
        if ($user) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:150',
                'email' => 'required|email|max:100',
            ]);

            if ($validator->fails()){
                $data = [
                    'status' => 422,
                    'message' => $validator->errors()->all()
                ];
        
                return response()->json($data, 422);
            } else {

                if ($user) {

                    $user->update([
                        'name' => $request->name,
                        'email' => $request->email,
                    ]);

                    $data = [
                        'status' => 201,
                        'message' => "User Updated Successfuly"
                    ];
            
                    return response()->json($data, 201);
                } else {
                    $data = [
                        'status' => 404,
                        'message' => "User Not Found"
                    ];
            
                    return response()->json($data, 404);
                }

            }
        } else {
            $data = [
                'status' => 404,
                'message' => 'User Not Found'
            ];
    
            return response()->json($data, 404);
        } 
    }

    public function delete(int $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();

            $data = [
                'status' => 200,
                'message' => 'User Deleted Successfuly'
            ];
    
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'User Not Found'
            ];
    
            return response()->json($data, 404);
        } 
    }

}
