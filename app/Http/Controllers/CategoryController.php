<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Function: addCategory
     * Description: This function is used to addCategory API
     * @param NA
     * @return JsonResponse
     */
    public function addCategory(Request $request){
        try{
            $userId = $request->header('id');

            $result = Category::create([
                'name' => $request->input('name'),
                'userId' => $userId
            ]);
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Category added successfully!'
            ],201);
        }catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Something went wrong!"
            ],500);
        }
    }
    /**
     * Function: getAllCategory
     * Description: This function is used to getAllCategory API
     * @param NA
     * @return JsonResponse
     */
    public function getAllCategories(Request $request){
        try{
            $userId = $request->header('id');
            $allCategories = Category::where('userId',$userId)->get();
            return response()->json([
                'success' => true,
                'data' => $allCategories,
                'message' => 'All Categories retrieved successfully!'
            ],201);
        }catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Something went wrong!"
            ],500);
        }
    }
    /**
     * Function: getByID
     * Description: This function is used to getByID API
     * @param NA
     * @return JsonResponse
     */
    public function getByID(Request $request,$id)
    {
        $userId = $request->header('id');
        $findCategory = Category::where('userId',$userId)->where('id',$id)->first();
        if($findCategory){
            $result = Category::where('id',$id)->where('userId',$userId)->get();
            return response()->json([
                'success' => true,
                'data' => $result,
                'message' => 'Category retrieved successfully!'
            ],201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Category not found!'
            ],404);
        }
    }
    /**
     * Function: updateCategory
     * Description: This function is used to updateCategory API
     * @param NA
     * @return JsonResponse
     */
    public function updateCategory(Request $request,$id){
        try{
            $userId = $request->header('id');
            $findCategory = Category::where('userId',$userId)->where('id',$id)->first();
            if($findCategory){
                $updateCategory = Category::where('userId',$userId)->where('id',$id)->update([
                    'name' => $request->input('name'),
                ]);
                return response()->json([
                    'success' => true,
                    'data' => $updateCategory,
                    'message' => 'Category updated successfully!'
                ],201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found!'
                ],404);
            }
        }catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Something went wrong!"
            ],500);
        }
    }
    /**
     * Function: deleteCategory
     * Description: This function is used to deleteCategory API
     * @param NA
     * @return JsonResponse
     */
    public function deleteCategory(Request $request,$id){
        try{
            $userId = $request->header('id');
            $findCategory = Category::where('userId',$userId)->where('id',$id)->first();
            if($findCategory){
                $deleteCategory = Category::where('userId',$userId)->where('id',$id)->delete();
                return response()->json([
                    'success' => true,
                    'data' => $deleteCategory,
                    'message' => 'Category deleted successfully!'
                ],201);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found!'
                ],404);
            }
        }catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => "Something went wrong!"
            ],500);
        }
    }
}
