<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $post = PostResource::collection(Post::get());
        return $this->apiResponse($post, 'ok', 200);   
    }


    public function show($id)
    {
  ///// *************************************** Start ////////////********* */      
// = error بيعطيني  Table مش بألب ال  id إذا بدي حط 
//Trying to get property 'id' of non-object
        
    //  $post = new PostResource(Post::find($id));
    //     if($post)
    //     {
    //         return $this->apiResponse($post, 'ok', 200); 
    //     }
    //      return $this->apiResponse(null, 'This post not found', 401); 

    ///// ********************* End ////////////********* */ 



    ///// ********************************** Start ////////////********* */ 

    //  بيعطيني  Table مش بألب ال  id إذا بدي حط 
   /* "data": null,
    "message": "This post not found",
    "status": 401 */


        $post = Post::find($id);
        if($post)
        {
            return $this->apiResponse(new PostResource($post), 'ok', 200); 
        }
         return $this->apiResponse(null, 'This post not found', 404);
    }

    ///// **************** End //////*********************** */ 


    public function store(Request $request)
    {
        // 1- validation
        $validator = Validator::make ($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->apiResponse(null, $validator->errors(), 400); 
        }
        
       // 2- insert data
      $post = Post::create($request->all());
      if($post)
        {
            return $this->apiResponse(new PostResource($post), 'the post saved successfully', 201); 
        }
        return $this->apiResponse(null, 'This post not Saved', 400);

    }


    public function update(Request $request, $id)
    {
      //  1- validation
        $validator = Validator::make ($request->all(), [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->apiResponse(null, $validator->errors(), 400); 
        }

      
      // 2- bet2akad eza mawjood l id aw la  
        $post = Post::find($id);
        if(!$post)
        {
            return $this->apiResponse(null, 'This post not found {number of id} ', 404); 
        }


        // 3- update data
         $post->update($request->all());
         if($post)
          {
              return $this->apiResponse(new PostResource($post), 'the post updated successfully', 201); 
          } 
  
    }

    public function destroy($id)
    {
        // 1- bet2akad eza mawjood l id aw la  
        $post = Post::find($id);
        
        if(!$post)
        {
            return $this->apiResponse(null, 'This post not found  del {number of id } ', 404); 
        } 

        // 2- delete Data
        $post->delete($id);
        if($post)
          {
              return $this->apiResponse(null, 'the post Deleted successfully', 201); 
          }



    }
}
