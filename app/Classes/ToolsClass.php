<?php

namespace App\Classes;

use App\Models\RoomInformationModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ToolsClass
{
    public function get_room_list($search_data = "") {

        $room_list = RoomInformationModel::select('id', 'name')
            ->when($search_data != "", function ($room_list) use ($search_data){
                $room_list->where('name', 'like', "%$search_data%");
            })
            ->where('status', '=', "1")
            ->orderBy('name', 'ASC')
            ->get();

        return $room_list;

    }

    public function paginate($items, $perPage = 10, $page = null) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total   ,$perPage);
    }

}
