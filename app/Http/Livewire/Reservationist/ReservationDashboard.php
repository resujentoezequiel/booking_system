<?php

namespace App\Http\Livewire\Reservationist;

use App\Classes\ReservationistClass;
use App\Classes\ToolsClass;
use Livewire\Component;
use Illuminate\Http\Request;

class ReservationDashboard extends Component
{
    public function render(Request $request)
    {

        $search_value = $request->search_value;

        $reservationist_class = new ReservationistClass;
        $tools_class = new ToolsClass;

        $startTime = microtime(true);
        $raw_dashboard = $reservationist_class->get_dashboard_data($search_value);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        $dashboard_array = json_decode($raw_dashboard, true);
        $dashboard = $tools_class->paginate($dashboard_array);
        $dashboard->withPath('');


        return view('livewire.reservationist.reservation-dashboard',
            [
                'value' => $dashboard
                , 'count_data' => count($raw_dashboard)
                , 'execution_time' => round($executionTime, 2)
            ]
        );
    }
}
