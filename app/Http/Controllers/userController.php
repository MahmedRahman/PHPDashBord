<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\returnSelf;

class userController extends Controller
{


    public function index()
    {


        try {
            $user = auth()->user();

            if ($user->role === 'employee') {
                throw new Exception("cannot access Users data");
            }

            $users = User::where('role', '!=', 'admin')->get();
            return ResponseHelper::makeResponse('Operation successful', new UserCollection($users));

            //  return ResponseHelper::makeResponse('Operation successful', new UserCollection($users));
        } catch (\Exception $e) {
            return ResponseHelper::makeResponse('', $e->getMessage(), true, 400);
        }


    }

    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            if ($user->role === 'employee') {

                throw new Exception("cannot access Users data");
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role' => 'required|string|in:employee,hr,techlead',
                'is_active' => 'boolean',
                'vacation_days' => 'required|integer|between:1,40',
                'join_date' => 'required|date_format:Y-m-d',
                'employee_no' => 'required|string|max:255',
                'department_id' => 'required|string|max:255',
                'job_titles_id' => 'required|string|max:255',
            ]);


            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
                'is_active' => $validatedData['is_active'],
                'vacation_days' => $validatedData['vacation_days'],
                'join_date' => $validatedData['join_date'],
                'employee_no' => $validatedData['employee_no'],// Sets the join date to the current date
                'department_id' => $validatedData['department_id'],
                'job_titles_id' => $validatedData['job_titles_id'],
            ]);

            $token = $user->createToken('web-token')->plainTextToken;


            return ResponseHelper::makeResponse('Operation successful', ['user' => $user, 'access_token' => $token], );

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors);
            $firstErrorMessage = reset($firstError);
            return ResponseHelper::makeResponse($firstErrorMessage, [], true, 400);
        } catch (Exception $e) {
            return ResponseHelper::makeResponse($e->getMessage(), [], true, 400);
        }


    }


    public function delete($id)
    {

        try {
            $user = auth()->user();
            if ($user->role === 'employee') {
                throw new Exception("cannot access Users data");
            }

            $user = User::find($id);
            if (!$user) {
                throw new \Exception('User Id Not Found');
            }


            if ($user["role"] !== "employee") {
                throw new \Exception('We Can Only Delete Employee Users');
            }

            $user->delete();
            return ResponseHelper::makeResponse("User deleted successfully", []);

        } catch (\Exception $e) {
            return ResponseHelper::makeResponse($e->getMessage(), [], true, 400);
        }



    }

    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();
            if ($user->role === 'employee') {
                throw new Exception("cannot access Users data");
            }

            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users',
                'password' => 'nullable|string|min:8',
                'role' => 'nullable|string|in:employee,hr,techlead',
                'is_active' => 'nullable|boolean',
                'vacation_days' => 'nullable|integer|between:1,40',
                'join_date' => 'nullable|date_format:Y-m-d',
                'department_id' => 'nullable|integer',
                'job_title' => 'nullable|string',
                'employee_no' => 'nullable|string',
            ]);

            $user = User::find($id);
            if (!$user) {
                throw new \Exception('User not found');
            }

            $user->update($validatedData);

            return ResponseHelper::makeResponse('Operation successful', $user);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors); // Gets the first array of messages
            $firstErrorMessage = reset($firstError); // Gets the first message from the first array
            return ResponseHelper::makeResponse($firstErrorMessage, $firstErrorMessage, true, 400);
        } catch (\Exception $e) {
            return ResponseHelper::makeResponse($e->getMessage(), [], true, 400);
        }

    }
}
