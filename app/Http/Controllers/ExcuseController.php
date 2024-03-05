<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\ExcuseCollection;
use App\Http\Resources\ExcuseResource;
use App\Models\Excuse;
use Illuminate\Http\Request;

class ExcuseController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return response()->json(['message' => 'Admin users cannot create excuses.'], 403);
        }

        $validatedData = $request->validate([
            'create_date' => 'required|date',
            'stating' => 'nullable|string',
            'ending' => 'nullable|string',
            'state' => 'required|string|in:approval,rejection,wait_for_reply',
            'user_id' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);


        $excuse = Excuse::create([
            'create_date' => $validatedData['create_date'],
            'stating' => $validatedData['stating'],
            'ending' => $validatedData['ending'],
            'state' => $validatedData['state'],
            'user_id' => $validatedData['user_id'] ?? $user->id,
            'comments' => $validatedData['comments'] ?? null,
        ]);
    
        return ResponseHelper::makeResponse('Operation successful',$excuse);

    }

    public function index()
    {
        $excuses = Excuse::all();
        return ResponseHelper::makeResponse('Operation successful', ExcuseResource::collection($excuses));

    }

    public function show($id)
    {
        $excuse = Excuse::find($id);
        if ($excuse) {
            return response()->json(['data' => $excuse]);
        } else {
            return response()->json(['message' => 'Excuse not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $excuse = Excuse::find($id);
        if (!$excuse) {
            return response()->json(['message' => 'Excuse not found'], 404);
        }

        $validatedData = $request->validate([
            'create_date' => 'required|date',
            'stating' => 'nullable|string',
            'ending' => 'nullable|string',
            'state' => 'required|string|in:approval,rejection,wait_for_reply',
            'user_id' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);

        $excuse->update($validatedData);
        return response()->json(['message' => 'Excuse updated successfully', 'data' => $excuse]);
    }

    public function delete($id)
    {
        $excuse = Excuse::find($id);
        if (!$excuse) {
            return response()->json(['message' => 'Excuse not found'], 404);
        }

        $excuse->delete();
        return response()->json(['message' => 'Excuse deleted successfully']);
    }


}
