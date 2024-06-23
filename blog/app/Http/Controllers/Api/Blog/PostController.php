<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Blog\BaseController;
use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Jobs\BlogPostAfterDeleteJob;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::with(['user', 'category'])->paginate(5);

        return $posts;
    }
    public function forComboBox()
    {
        $posts = BlogPost::with(['user', 'category'])->get();
        return $posts;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostCreateRequest $request)
    {
        Log::info('Api\PostController@store');
        $data = $request->input();

        $item = (new BlogPost())->create($data);

        if ($item) {
            return response()->json([
                'success' => true,
                'message' => 'Пост успішно створено',
                'data' => $item
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Помилка збереження'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = BlogPost::with(['user','category'])->find($id);
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostUpdateRequest $request, string $id)
    {
        Log::info('5345345345345345345');
        $item = BlogPost::find($id);
        if (empty($item)) { // якщо ід не знайдено
            return response()->json([
                'success' => false,
                'message' => "Запис id=[{$id}] не знайдено"
            ], 404);
        }

        $data = $request->all(); // отримаємо масив даних, які надійшли з форми

        $result = $item->update($data); // оновлюємо дані об'єкта і зберігаємо в БД

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Помилка збереження'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = BlogPost::destroy($id); //софт деліт, запис лишається

        //$result = BlogPost::find($id)->forceDelete(); //повне видалення з БД

        if ($result) {
            BlogPostAfterDeleteJob::dispatch($id)->delay(20);
            return response()->json([
                'success' => true,
                'message' => 'Успішно видалено'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Помилка видалення'
            ], 500);
        }
    }
}
