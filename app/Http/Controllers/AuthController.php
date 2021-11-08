<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Krs;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Helpers\Firebase;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    public function register(Request $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
            'fcm_token' => Str::random(20)
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        $token = auth()->guard('api')->attempt($credentials);

        if ($token) {
            if ($request->filled('device_id')) {
                Firebase::unSubscribeAllTopic(auth('api')->user()->fcm_token);
                Firebase::unSubscribeAllTopicByDeviceId($request->device_id);
                Firebase::updateDeviceId(auth('api')->user()->fcm_token, $request->device_id);

                if (auth('api')->user()->student) {
                    $classrooms = Krs::where('student_id', auth('api')->user()->id)
                        ->select('classroom_id')
                        ->get();

                    foreach ($classrooms as $classroom) {
                        Firebase::subscribeTopic($classroom->classroom_id, $request->device_id);
                    }
                }
            }
        }

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function getAuthUser(Request $request)
    {
        if (auth('api')->user()->lecturer) {
            return response()->json([
                'data' => [
                    'account' => auth('api')->user(),
                    'user' => auth('api')->user()->lecturer
                ]
            ]);
        } else {
            return response()->json([
                'data' => [
                    'account' => auth('api')->user(),
                    'user' => auth('api')->user()->student
                ]
            ]);
        }
    }

    public function isLogin()
    {
        try {
            $user = auth('api')->user();
            if ($user) {
                return response()->json([
                    'message' => ['isLogin' => true]
                ]);
            }
            return response()->json([
                'message' => ['isLogin' => false]
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'message' => ['isLogin' => false]
            ], 401);
        }
    }

    public function logout()
    {
        auth()->guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        if (auth('api')->user()->lecturer) {
            return response()->json([
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'name' => auth('api')->user()->lecturer->name,
                    'nip' => auth('api')->user()->lecturer->nip,
                ]
            ]);
        } else {
            return response()->json([
                'data' => [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'name' => auth('api')->user()->student->name,
                    'nim' => auth('api')->user()->student->nim,
                ]
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|different:old_password',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 403);
        }

        try {
            $user = auth('api')->user();
            $old_password = $request->old_password;
            if ($user) {
                $current_pass = $user->password;
                if (Hash::check($old_password, $current_pass)) {
                    $user->password = Hash::make($request->password);
                    $user->update();
                    return response()->json([
                        'success' => true,
                        'message' => 'Password successfully updated'
                    ]);
                } else {
                    $validator->errors()->add('old_password', 'The current password field does not match your password');
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()
                    ], 401);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Password has not updated successfully'
            ], 401);
        }
    }

}
