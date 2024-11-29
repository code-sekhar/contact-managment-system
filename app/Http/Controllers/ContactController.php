<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Function: addContact
     * Description: This function is used to addContacts user API
     * @param NA
     * @return JsonResponse
     */
    public function addContact(Request $request){
        try{
            $user_Id = $request->header('id');
            $reuslt = Contact::where('user_id',$user_Id)->create([
                'user_id'=>$user_Id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'category_id' => $request->input('category_id')
            ]);
            return response()->json([
                'success'=>true,
                'data'=>$reuslt,
                'message'=>'Contact added successfully'
            ],201);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> "Something went wrong"
            ],500);
        }
    }
    /**
     * Function: showContacts
     * Description: This function is used to showContacts user API
     * @param NA
     * @return JsonResponse
     */
    public function showContacts(Request $request){
        try{
            $user_Id = $request->header('id');
            $data = Contact::where('user_id',$user_Id)->get();
            return response()->json([
                'success'=>true,
                'data'=>$data,
                'message'=>'Show All Contacts'
            ],201);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> "Something went wrong"
            ],500);
        }
    }
    /**
     * Function: showContactsbyID
     * Description: This function is used to showContacts user API
     * @param NA
     * @return JsonResponse
     */
    public function showContactsbyID(Request $request,$id){
        try{
            $user_Id = $request->header('id');
            $contactFind = Contact::where('user_id',$user_Id)->where('id',$id)->first();
            if($contactFind){
                return response()->json([
                    'success'=>true,
                    'data'=>$contactFind,
                    'message'=>'find Contact'
                ],201);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Contact not found'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> "Something went wrong"
            ],500);
        }
    }
    /**
     * Function: updateContact
     * Description: This function is used to updateContact user API
     * @param NA
     * @return JsonResponse
     */
    public function updateContact(Request $request,$id){
        try{
            $user_Id = $request->header('id');
            $contact_Find = Contact::where('user_id',$user_Id)->where('id',$id)->first();
            if($contact_Find){
                $data = Contact::where('user_id',$user_Id)->where('id',$id)->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                ]);
                return response()->json([
                    'success'=>true,
                    'data'=>$data,
                    'message'=>'Contact updated successfully'
                ],201);
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Contact not found'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> "Something went wrong"
            ],500);
        }
    }
    /**
     * Function: deleteContact
     * Description: This function is used to deleteContact  API
     * @param NA
     * @return JsonResponse
     */
    public function deleteContact(Request $request,$id)
    {
        try{
            $user_Id = $request->header('id');
            $findContact = Contact::where('user_id',$user_Id)->where('id',$id)->first();
            if($findContact){
                $delete = Contact::where('user_id',$user_Id)->where('id',$id)->delete();
                if($delete){
                    return response()->json([
                        'success'=>true,
                        'message'=>'Contact deleted successfully'
                    ],201);
                }
            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'Contact not found'
                ],404);
            }
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=> "Something went wrong"
            ],500);
        }
    }
}
