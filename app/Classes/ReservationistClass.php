<?php

namespace App\Classes;

use App\Models\ReservationInformationModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationistClass
{

    public function create_reservation(Request $request) {

        $minutes_count = htmlspecialchars(str_replace( array( '\'', '"',',', ';', '<', '>' ), "", $request['minutes_count']));
        $room_id = $request['room_id'];
        $appointment_date = date_format(date_create($request['appointment_date']),"Y-m-d H:i:s");

        $date_reservation = date_format(date_create($appointment_date),"Y-m-d");
        $raw_minutes = ($minutes_count == "60")? "01:00" : "00:" . $minutes_count;
        $time_start = date_format(date_create($appointment_date),"H:i");
        $minutes_to_add = date_format(date_create($raw_minutes),"H:i");

        $secs = strtotime($minutes_to_add)-strtotime("00:00:00");
        $time_end = date("H:i",strtotime($time_start)+$secs);

        $start_time_covert = str_replace(":" ,"",$time_start);
        $end_time_covert = str_replace(":" ,"",$time_end);

        $insert_data = ReservationInformationModel::create([
            'reservationist' => Auth::user()->name,
            'room_id' => $room_id,
            'date_reservation' => $date_reservation,
            'start_time' => $start_time_covert,
            'end_time' => $end_time_covert,
            'minutes_count' => $minutes_count,
            'reservation_status' => "1",
            'created_at' => date("Y-m-d h:i:s"),
        ]);

        return back()
            ->with("success_add","You have successfully added the new reservation.");

    }

    public function check_availability(Request $request) {

        $appointment_date = date_format(date_create($request['appointment_date']),"Y-m-d H:i:s");
        $room_id = $request['room_id'];
        $date_reservation = date_format(date_create($appointment_date),"Y-m-d");
        $time_start = date_format(date_create($appointment_date),"H:i");

        $start_time_covert = str_replace(":" ,"",$time_start);


        $check_data = ReservationInformationModel::select('id')
            ->where('room_id', "=", $room_id)
            ->where('date_reservation', "=", $date_reservation)
            ->where(function($check_data) use ($start_time_covert){
                $check_data->where('start_time','<=',$start_time_covert)
                    ->Where('end_time','>=',$start_time_covert);
            })
            ->where(function($check_data){
                $check_data->where('reservation_status','=', "1")
                    ->OrWhere('reservation_status','=', "2");
            })
            ->get()
            ->toArray();

        return $check_data;

    }

    public function get_dashboard_data($search_data = "", $status = "") {

        $search_data = htmlspecialchars($search_data);
        $user_name = Auth::user()->name;

        $data_list = ReservationInformationModel::select(
            'reservation_information.id'
            , 'reservation_information.reservationist'
            , 'reservation_information.room_id'
            , 'room_information.name as room_name'
            , 'reservation_information.date_reservation'
            , 'reservation_information.start_time'
            , 'reservation_information.end_time'
            , 'reservation_information.minutes_count'
            , 'reservation_information.reservation_status as r_id'
            , 'reservation_status.name as r_status'
            , 'reservation_information.created_at'
        )
            ->leftJoin('room_information','reservation_information.room_id','=', 'room_information.id')
            ->leftJoin('reservation_status','reservation_information.reservation_status','=','reservation_status.id')
            ->when($search_data != "", function ($data_list) use ($search_data){
                $data_list->where('reservation_information.id', "=", $search_data);
            })
            ->when($status == "", function ($data_list){
                $data_list->where('reservation_information.reservation_status', "!=", "4");
            })
            ->where('reservation_information.reservationist', "=", $user_name)
            ->get();

        return $data_list;

    }
    public function delete_reservation_data($id = "") {

        ReservationInformationModel::where("id", '=', $id)
            ->update([
                'reservation_status' => "4",
            ]);

        return back()
            ->with("success_add","You have successfully deleted the reservation data.");

    }

    public function generate_report() {

        $data_list = $this->get_dashboard_data("","all");
        $fileName = 'BOOKING SYSTEM REPORT ' . date("Y-m-d") . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('RESERVATION ID'
        , 'RESERVATIONIST'
        , 'ROOM NAME'
        , 'DATE RESERVATION'
        , 'START TIME'
        , 'END TIME'
        , 'MINUTES'
        , 'RESERVATION STATUS'
        , 'DATE CREATED'
        );

        $callback = function() use($data_list, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data_list as $data_result) {

                $row['RESERVATION ID']  = $data_result['id'];
                $row['RESERVATIONIST']    = $data_result['reservationist'];
                $row['ROOM NAME']    = $data_result['room_name'];
                $row['DATE RESERVATION']    = $data_result['date_reservation'];
                $row['START TIME']    = $data_result['start_time'];
                $row['END TIME']    = $data_result['end_time'];
                $row['MINUTES']   = $data_result['minutes_count'];
                $row['RESERVATION STATUS']    = $data_result['r_status'];
                $row['DATE CREATED']  = $data_result['created_at'];

                $row_array = array($row['RESERVATION ID']
                , $row['RESERVATIONIST']
                , $row['ROOM NAME']
                , $row['DATE RESERVATION']
                , $row['START TIME']
                , $row['END TIME']
                , $row['MINUTES']
                , $row['RESERVATION STATUS']
                , $row['DATE CREATED']
                );

                fputcsv($file, $row_array);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }


}
