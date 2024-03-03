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

    
  


}