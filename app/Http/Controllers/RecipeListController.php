<?php

namespace App\Http\Controllers;

use App\RecipeList;
use Illuminate\Http\Request;
use JWTAuth;

class RecipeListController extends Controller
{
    protected $user;
    
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        return $this->user
            ->recipe_lists()
            ->get(['id', 'name', 'recipes'])
            ->toArray();
    }

    public function show($id)
    {
        $list = $this->user->recipe_lists()->find($id);
    
        if (!$list) {
            return response()->json([
                'success' => false,
                'message' => 'List could not be found'
            ], 400);
        }
    
        return $list;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
    
        $list = new RecipeList();
        $list->name = $request->name;
        $list->recipes = [];
    
        if ($this->user->recipe_lists()->save($list)) {
            return response()->json([
                'success' => true,
                'list' => $list
            ]);
        }

        else {
            return response()->json([
                'success' => false,
                'message' => 'List could not be added'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $list = $this->user->recipe_lists()->find($id);
    
        if (!$list) {
            return response()->json([
                'success' => false,
                'message' => 'List could not be found'
            ], 400);
        }
    
        $updated = $list->fill($request->all())->save();
    
        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'List could not be updated'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $list = $this->user->recipe_lists()->find($id);
    
        if (!$list) {
            return response()->json([
                'success' => false,
                'message' => 'List could not be found'
            ], 400);
        }
    
        if ($list->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'List could not be deleted'
            ], 500);
        }
    }
}
