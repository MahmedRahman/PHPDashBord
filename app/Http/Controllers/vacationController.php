<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\UserCollection;
use App\Http\Resources\VacationResource;
use App\Models\vacation;
use Exception;
use Illuminate\Http\Request;

class vacationController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user(); // Get the authenticated user
            if ($user->role === 'admin') {
                $vacation = Vacation::all();
            } else {
                $vacation = Vacation::where('user_id', $user->id)->get();
            }


            return ResponseHelper::makeResponse('Operation successful',VacationResource::collection($vacation)
        );

            //return ResponseHelper::makeResponse('Operation successful', $vacation);
        } catch (\Exception $e) {
            return ResponseHelper::makeResponse('', $e->getMessage(), true, 400);
        }
    }

    public function store(Request $request)
    {
        try {

            $user = auth()->user();
            if ($user->role === 'admin') {
                return response()->json(['message' => 'Admin users cannot create vacation requests.'], 403);
            }

            $validatedData = $request->validate([
                'create_date' => 'required|date',
                'stating' => 'required|date',
                'ending' => 'required|date',
                'days' => 'required|integer',
                'type' => 'required|string|in:annual,emergency,sick,without_pay',
                'state' => 'required|string|in:approval,rejection,wait_for_reply',
                'user_id' => 'nullable|integer', // Assuming user_id should be an integer, and nullable
                'comments' => 'nullable|string|max:255',
            ]);

            // Create the new vacation record
            $vacationRequest = Vacation::create([
                'create_date' => $validatedData['create_date'],
                'stating' => $validatedData['stating'],
                'ending' => $validatedData['ending'],
                'days' => $validatedData['days'],
                'type' => $validatedData['type'],
                'state' => $validatedData['state'],
                'user_id' => $validatedData['user_id'] ?? $user->id,
                'comments' => $validatedData['comments'] ?? null, // Use null if comments are not provided
            ]);

            return ResponseHelper::makeResponse('Operation successful', $vacationRequest);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors);
            $firstErrorMessage = reset($firstError);
            return ResponseHelper::makeResponse($firstErrorMessage, [], true, 400);
        } catch (Exception $e) {

            return ResponseHelper::makeResponse($e, [], true, 400);
        }

    }

    public function delete($id)
    {

        try {
            $vacation = vacation::find($id);
            if (!$vacation) {
                throw new \Exception('Vacation Id Not Found');
            }

            $vacation->delete();
            return ResponseHelper::makeResponse("Vacation deleted successfully", []);

        } catch (\Exception $e) {
            return ResponseHelper::makeResponse($e->getMessage(), [], true, 400);
        }



    }


    public function update(Request $request, $id)
    {
        try {


            $user = auth()->user();
            if ($user->role !== 'admin') {
                return response()->json(['message' => 'Only Admin users can update vacation requests.'], 403);
            }


            // Validate the incoming request data
            $validatedData = $request->validate([
                'stating' => 'nullable|date',
                'ending' => 'nullable|date',
                'days' => 'nullable|integer',
                'type' => 'nullable|string|in:annual,emergency,sick,without_pay',
                'state' => 'nullable|string|in:approval,rejection,wait_for_reply',
                'user_id' => 'nullable|integer',
                'comments' => 'nullable|string|max:255',
            ]);

            // Find the vacation record by ID
            $vacation = Vacation::find($id);
            if (!$vacation) {
                throw new \Exception('Vacation request not found');
            }

            // Update the vacation record with validated data
            $vacation->update($validatedData);

            // Return a success response
            return ResponseHelper::makeResponse('Vacation request updated successfully', $vacation);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions by returning the first error message
            $errors = $e->errors();
            $firstError = reset($errors); // Gets the first array of messages
            $firstErrorMessage = reset($firstError); // Gets the first message from the first array
            return ResponseHelper::makeResponse($firstErrorMessage, [], true, 400);
        } catch (\Exception $e) {
            // Handle general exceptions
            return ResponseHelper::makeResponse($e->getMessage(), [], true, 400);
        }
    }

}
