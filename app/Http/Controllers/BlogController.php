<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\BlogPosts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\BlogPostRepositoryInterface;

class BlogController extends Controller
{
    /**
    * @var BlogPostRepositoryInterface
    */

    protected $blogRepository;
    protected $userRepository;

    public function __construct(
        BlogPostRepositoryInterface $blogRepository
    )
    {
        $this -> blogRepository = $blogRepository;
    }

    public function index(Request $request)
    {
        $blogPost = $this->blogRepository->all();
        $own_id = $request -> user()-> id;
        try {
            return response()->json([
                'status' => true,
                'message' => "Successfully",
                'data' => $blogPost,
                'user' => $own_id
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function createBlog(Request $request)
    {
        try {

            //Validated
            $validateUser  = Validator::make($request-> all(),
            [
                'title' => 'required',
                'contents' => 'required'
            ]);
            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $own_id = $request -> user() -> id;
            $data = [
                'title' => $request->title,
                'contents' => $request->contents,
                'owner_id' => $own_id
            ];
            $this->blogRepository->store($data);
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