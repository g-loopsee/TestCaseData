<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index(){

        $dateFrom = date('Y-m-d');
        $dateTo = date('Y-m-d', strtotime('+100 day'));

        $result = file_get_contents("http://89.108.115.241:6969/api/orders?dateFrom=$dateFrom&dateTo=$dateTo&page=1&key=E6kUTYrYwZq2tN4QEtyzsbEBk3ie&limit=100");
        DB::unprepared('drop table if exists orders');
        $sqlCreate = 'create table if not exists orders (';

        $data = json_decode($result,true)['data'][0];
        foreach ($data as $key => $value) {
            if(is_numeric($value)){
                if ($value > 210000000){
                    $sqlCreate .= $key. " TEXT, ";
                }else{
                    $sqlCreate .= $key. " BIGINT, ";
                }
            }
            else if(is_bool($value)){
                $sqlCreate .= $key. " BOOL, ";
            }
            else{
                $sqlCreate .= $key. " VARCHAR(255), ";
            }

        }
        $sqlCreate = rtrim($sqlCreate, ', ') . ')';

        DB::unprepared($sqlCreate);

        $allData = json_decode($result,true)['data'];
        foreach ($allData as $key => $smallData) {
            $sqlInsert = 'insert into orders (';
            foreach ($smallData as $key => $value) {
                $sqlInsert .= $key.',';
            }
            $sqlInsert = rtrim($sqlInsert, ', ') . ')';
            $sqlInsert .= ' values (';
            foreach ($smallData as $key => $value) {
                $sqlInsert .= '?,';
            }
            $sqlInsert = rtrim($sqlInsert, ', ') . ')';

            $insertArray = [];
            foreach ($smallData as $key => $value) {
                $insertArray[] = $value;
            }

            DB::insert($sqlInsert, $insertArray);
        }
        return 'ORDERS SUCCESS';
    }
}
