<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;


class AuthController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */

    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this -> userRepository = $userRepository;
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $validateUser  = Validator::make($request-> all(),
                [
                    'name' => 'required',
                    'password' => 'required'
                ]);
            
            if ($validateUser -> fails()){
                return response()->json([
                    'status'=> false,
                    'message'=> 'Validator error',
                    'error'=> $validateUser -> errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['name', 'password']))) {
                $user = $this->userRepository->firstByWhere(['name' => $request->name]);
                if (!$user) {
                    return response()->json([
                        'status' => false,
                        'errors' => [
                            'name' => ['Tên đăng nhập không tồn tại'],
                        ],
                        'message' => 'Tên đăng nhập không tồn tại',
                    ], 401);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Sai mật khẩu',
                    'errors' => [
                        'password' => ['Sai mật khẩu'],
                    ],
                ], 401);
            }

            $user = $this->userRepository->firstByWhere(['name' => $request->name, 'is_verified' => 1]);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Số điện thoại đăng ký chưa được xác thực!!',
                    'errors' => [
                        'number_phone' => ['Số điện thoại đăng ký chưa được xác thực!!'],
                    ],
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'Đăng nhập thành công.',
                'data' => [
                    'user' => $user,
                    'acccess_token' => $user->createToken("API TOKEN")->plainTextToken
                ]
            ], 200);

        } catch (Exception $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function register(Request $request): JsonResponse
    {
        try {
            $messageError = [
                'name.unique' => 'Tên đăng nhập đã được đăng ký tài khoản.',
                'phone_number.unique' => 'Số điện thoại đã được đăng ký tài khoản.',
                'email.unique' => 'Email đã được đăng ký tài khoản.',
                'password.regex' => 'Mật khẩu dài từ 8-16 ký tự (bao gồm tối thiểu 1 chữ viết hoa và 1 chữ viết thường)',
                'name.regex' => 'Tên đăng nhập bao gồm chữ, số và gạch dưới “_”'
            ];
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required|string|max:30|regex:/^[a-zA-Z0-9_]*$/|unique:users,name',
                    'email' => 'required|string|email|unique:users,email',
                    'phone_number' => 'required|numeric|regex:/^[0-9]{9,11}$/|unique:users,phone_number',
                    'full_name' => 'required|string',
                    'company_name' => 'required|string',
                    'password' => 'required|string|min:8|max:16|regex:/^.*(?=.*[a-z])(?=.*[A-Z]).*$/'
                ], $messageError);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'full_name' => $request->full_name,
                'company_name' => $request->company_name,
                'password' => Hash::make($request->password)
            ];

            $user = $this->userRepository->store($data);

            // $userOtp = $this->userOtpRepository->generateOtp($user->id);

            // $this->smsService->sendOtpSms($user->phone_number, $userOtp->otp);

            return response()->json([
                'status' => true,
                'message' => 'Successfully',
                'data' => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}