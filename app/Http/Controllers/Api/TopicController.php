<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use Illuminate\Http\Request;
use App\Http\Resources\Topic as TopicResource;
use App\Post;
// use Illuminate\Http\Request;
use App\Topic;
class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics=Topic::paginate(3);
        return TopicResource::collection($topics);
        //
    }


    public function store(CreateTopicRequest $request)
    {
        $topic = new Topic;
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic->save();
        $topic->posts()->save($post);

        return new TopicResource($topic);
    }


    public function show(Topic $topic)
    {
        return new TopicResource($topic);
    }

    /**
     * @param UpdateTopicRequest $request
     * @param Topic $topic
     * @return TopicResource
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $topic->title=$request->get('title',$topic->title);
        $topic->save();
        return new TopicResource($topic);

    }

    /**
     * @param Topic $topic
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return response()->json(["status"=>"deleted"],204);
    }
}
