<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;

class DiggingDeeperController extends Controller
{
    /**
     * Базова інформація
     * @url https://laravel.com/docs/11.x/collections#introduction
     *
     * Довідкова інформація
     * @url https://laravel.com/api/11.x/Illuminate/Support/Collection.html
     *
     * Варіант колеції для моделі eloquent
     * @url https://laravel.com/api/11.x/Illuminate/Database/Eloquent/Collection.html
     *
     */

    public function collections()
    {
        $result = [];

        /**
         * @var \Illuminate\Database\Eloquent\Collection $eloquentCollections
         */
        $eloquentCollection = BlogPost::withTrashed()->get();

        //dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

        /**
         * @var \Illuminate\Support\Collection $collection
         */
        $collection = collect($eloquentCollection->toArray());

        /* dd(
             get_class($eloquentCollection),
             get_class($collection),
             $collection
         );*/


        $result['first'] = $collection->first(); //вибираємо 1 елемент
        $result['last'] = $collection->last();  //вибираємо останній елемент

        $result['where']['data'] = $collection
            ->where('category_id', 10)  //вибираємо елементи з категорією 10
            ->values()  //беремо лише значення без ключів
            ->keyBy('id');  //прирівнюємо id з бд з ключем масива

        $result['where']['count'] = $result['where']['data']->count();
        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();



        if ($result['where']['data']->isNotEmpty()) {
            //
        }

        $result['where_first'] = $collection
            ->firstWhere('created_at', '>' , '2020-02-24 03:46:16');

        //Базова змінна не змінюється. Вертаємо змінено версію.
        $result['map']['all'] = $collection->map(function ($item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);

            return $newItem;
        });

        $result['map']['not_exists'] = $result['map']['all']->where('exists', '=', false)->values()->keyBy('item_id');  //витягаємо видалені елементи

        //dd ($result);

        //Базова змінна змінюється (трансформується).
        $collection->transform(function ($item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);

            return $newItem;
        });

        //dd ($collection);

        $newItem = new \stdClass;
        $newItem->id = 9999;

        $newItem2 = new \stdClass;
        $newItem2->id = 8888;

        //dd ($newItem, $newItem2);

        //Додаємо елемент в початок/кінець колекції
        $newItemFirst = $collection->prepend($newItem)->first(); //додали в початок
        $newItemLast = $collection->push($newItem2)->last(); //додали в кінець
        $pulledItem = $collection->pull(1); //забрали з першим ключем

        //dd(compact('collection', 'newItemFirst' , 'newItemLast', 'pulledItem'));

        //Фільтрація
        $filtered = $collection->filter(function ($item) {
            $byDay = $item->created_at->isFriday();   //питаємо Carbon
            $byDate = $item->created_at->day == 11;

            $result = $byDay && $byDate;
            //$result = $item->created_at->isFriday() && ($item->created_at->day == 11); так робити не варто

            return $result;
        });

        //dd(compact('filtered')); //закоментувати 91-106 рядки перед перевіркою

        $sortedSimpleCollection = collect([5, 3, 1, 2, 4])->sort()->values();
        $sortedAscCollection = $collection->sortBy('created_at');
        $sortedDescCollection = $collection->sortByDesc('item_id');

        //dd(compact('sortedSimpleCollection', 'sortedAscCollection', 'sortedDescCollection'));

    }
}
