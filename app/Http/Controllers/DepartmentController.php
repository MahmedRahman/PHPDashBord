<?php

namespace App\Http\Controllers;
use Exception;

use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceResponse;
use App\Helpers\ResponseHelper;

class DepartmentController extends Controller
{
    //

    public function index(){
        try {
            $deparment = department::all();
             return ResponseHelper::makeResponse('Operation successful', $deparment);
         } catch (\Exception $e) {
             return ResponseHelper::makeResponse('', $e->getMessage(), true, 400);
         }
    }

    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
            ]);

            $department = department::create([
                'title' => $validatedData['title'],
            ]);
           
            return ResponseHelper::makeResponse('Operation successful', $department );

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors); 
            $firstErrorMessage = reset($firstError); 
            return ResponseHelper::makeResponse($firstErrorMessage, [], true, 400);
        } catch (Exception $e) {
            return ResponseHelper::makeResponse($e,[] , true, 400);
        }

    }


    public function delete($id)
    {

        try {
            $department = department::find($id);
            if (!$department) {
                throw new \Exception('Department Id Not Found');
            }

             $department->delete();
            return ResponseHelper::makeResponse("Department deleted successfully", []);

        } catch (\Exception $e) {
            return ResponseHelper::makeResponse($e->getMessage(), [], true, 400);
        }



    }

}
