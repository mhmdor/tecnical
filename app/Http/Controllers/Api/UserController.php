<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;

class UserController extends ApiController
{
    public function register(Request $request)
    {

        $validator = $this->apiValidation($request, [
            'name' => 'required|string|max:255',
            'lat' => 'required|numeric|max:255',
            'lang' => 'required|numeric|max:255',
            'bank' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
            'photo' => 'required',
            'mobile' => 'required|unique:users,mobile|string|max:255',
            'residence' => 'required',
            'subCategoryIds' => 'required',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                ,
            ],
        ]);
        if ($validator instanceof Response)
            return $validator;


        $filename = rand() . time();
        $destinationPathImg = public_path('uploads/photoUpload/');
        if (!$request->file('photo')->move($destinationPathImg, $filename)) {
            return 'Error saving the file.';
        }
        $file = $filename;
        $filename1 = rand() . time();
        $destinationPathImg = public_path('uploads/residenceUpload/');
        if (!$request->file('residence')->move($destinationPathImg, $filename1)) {
            return 'Error saving the file.';
        }
        $file1 = $filename1;
        $User = User::create([
            'name' => $request->name,
            'lat' => $request->lat,
            'bank' => $request->bank,
            'lang' => $request->lang,
            'iban' => $request->iban,
            'mobile' => $request->mobile,
            'photo' => $file,
            'residence' => $file1,
            'password'=> Hash::make($request->password),
        ]);

        $User->category()->attach($request->subCategoryIds);



        return $this->apiResponse(['User' => new UserResource($User),], self::STATUS_CREATED, 'register User successfully');

    }

    public function index(Request $request)
    {
        $users = User::where('active',0)->get();

        return $this->apiResponse(['users' =>  UserResource::collection($users),], self::STATUS_OK, 'get Users successfully');
    }


    public function activeUsers(Request $request)
    {
        $users = User::where('active',1)->get();

        return $this->apiResponse(['users' =>  UserResource::collection($users),], self::STATUS_OK, 'get Users successfully');
    }

    public function active($id)
    {
        $users = User::where('id',$id)->first();

        if (!$users) {

            return $this->apiResponse(null, self::STATUS_UNAUTHORIZED, 'user not found');
        }
        
        $users->update([
            'active'=> 1
        ]);

        return $this->apiResponse(['user' => new UserResource($users),], self::STATUS_OK, 'ativity User successfully');
    }

    public function login(Request $request)
    {

        $validate = $this->apiValidation($request, [
            'mobile' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if ($validate instanceof Response)
            return $validate;


        $User = User::where('mobile', $request->mobile)->first();

        if (!$User || !Hash::check($request->password, $User->password)) {

            return $this->apiResponse(null, self::STATUS_UNAUTHORIZED, 'your mobile or password invalid ');
        }



        if ($User->active == 0) {

            return $this->apiResponse(null, self::STATUS_UNAUTHORIZED, 'sorry you are not active');
        }



        return $this->apiResponse(['user' => new UserResource($User), ], self::STATUS_CREATED, 'get user successfully');

    }
}
