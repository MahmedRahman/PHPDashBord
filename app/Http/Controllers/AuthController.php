<?php
namespace App\Http\Controllers;
use App\Helpers\ResponseHelper;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $user = $request->user();
                $token = $user->createToken('web-token')->plainTextToken;
                return ResponseHelper::makeResponse("", [
                    'access_token' => $token,
                    'user' => $user
                ]);
            }
            throw new \Exception('Bad Email Or Password');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors); // Gets the first array of messages
            $firstErrorMessage = reset($firstError); // Gets the first message from the first array
            return ResponseHelper::makeResponse($firstErrorMessage, [], true, 400);
        } catch (\Exception $e) {
            return ResponseHelper::makeResponse($e->getMessage(), [], true, 400);
        }

    }

    public function registerNewEmployee(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

           

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'employee',
                'is_active' =>  false ,
                'vacation_days' => 0,
                'join_date' => now()->format('Y-m-d'), // Sets the join date to the current date
            ]);

            $token = $user->createToken('web-token')->plainTextToken;


            return ResponseHelper::makeResponse('Operation successful', ['user' => $user, 'access_token' => $token], );

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors); // Gets the first array of messages
            $firstErrorMessage = reset($firstError); // Gets the first message from the first array
            return ResponseHelper::makeResponse($firstErrorMessage, [], true, 400);
        }


    }

    
    public function listUsers()
    {
        try {
           // $users = User::all();
           
           $users = User::where('role', '!=', 'admin')->get();

            return ResponseHelper::makeResponse('Operation successful', new UserCollection($users));
        } catch (\Exception $e) {
            return ResponseHelper::makeResponse('', $e->getMessage(), true, 400);
        }


    }

    public function addUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'role'=> 'required|string|in:employee,hr,techlead',
                'is_active' => 'boolean' ,
                'vacation_days' => 'required|integer|between:1,40',
                'join_date' => 'required|date_format:Y-m-d',
                'department'=> 'required|string|in:Engineering,Sales and Marketing,Human Resources',
                'job_title'=> 'required|string|in:Front-end Developer,Back-end Developer,Mobile Developer,UX/UI Designer,HR Manager,Operations Manager',
                'employee_no' => 'required|string|max:255',
            ]);

           

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
                'is_active' =>  $validatedData['is_active'] ,
                'vacation_days' => $validatedData['vacation_days'],
                'join_date' => $validatedData['join_date'], 
                'department' => $validatedData['department'],
                'job_title' => $validatedData['job_title'],
                'employee_no' => $validatedData['employee_no'],// Sets the join date to the current date
            ]);

            $token = $user->createToken('web-token')->plainTextToken;


            return ResponseHelper::makeResponse('Operation successful', ['user' => $user, 'access_token' => $token], );

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors); 
            $firstErrorMessage = reset($firstError); 
            return ResponseHelper::makeResponse($firstErrorMessage, [], true, 400);
        } catch (Exception $e) {
            return ResponseHelper::makeResponse('', [], true, 400);
        }


    }

    public function showUser($id)
    {
       
        try {
            $user = User::find($id);
            if (!$user) {
                throw new \Exception('User Id Not Found');
            }

            $user->is_active = (bool) $user->is_active;
            //return new UserResource($user);
            return ResponseHelper::makeResponse("User successfully",new UserResource($user) );

        } catch (\Exception $e) {
            return ResponseHelper::makeResponse($e, [], true, 400);
        }



    }

    public function deleteUser($id)
    {

        try {
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

    public function updateUser(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users',
                'password' => 'nullable|string|min:8',
                'role'=> 'nullable|string|in:employee,hr,techlead',
                'is_active' => 'nullable|boolean' ,
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