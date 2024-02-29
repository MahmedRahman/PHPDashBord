<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\job_title;
use Exception;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    public function index(){
        try {
            $jobTitle = job_title::all();
            
             return ResponseHelper::makeResponse('Operation successful', $jobTitle);
         } catch (\Exception $e) {
             return ResponseHelper::makeResponse('', $e->getMessage(), true, 400);
         }
    }

    public function store(Request $request){
        try {
            $validatedData = $request->validate([
                'departments_id' => 'required|string|max:255',
                'title' => 'required|string|max:255',
            ]);

            $jobTitle = job_title::create([
                'departments_id' => $validatedData['departments_id'],
                'title' => $validatedData['title'],
            ]);
          
            return ResponseHelper::makeResponse('Operation successful', $jobTitle );

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
            $jobTitle = job_title::find($id);
            if (!$jobTitle) {
                throw new \Exception('Department Id Not Found');
            }

             $jobTitle->delete();
            return ResponseHelper::makeResponse("Department deleted successfully", []);

        } catch (\Exception $e) {
            return ResponseHelper::makeResponse($e->getMessage(), [], true, 400);
        }



    }

}
