<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::with(['parentCategory'])->paginate(5);

        return $categories;
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
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();

        $item = (new BlogCategory())->create($data);

        if ($item) {
            return response()->json([
                'success' => true,
                'message' => 'Категорія успішно створено',
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
        $post = BlogCategory::with(['parentCategory'])->find($id);
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
    public function update(BlogCategoryUpdateRequest $request, string $id)
    {
        $item = BlogCategory::find($id);
        if (empty($item)) {
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
        $result = BlogCategory::destroy($id);
        if ($result) {
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
