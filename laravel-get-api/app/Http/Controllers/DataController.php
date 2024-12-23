<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function index(){
        $url = 'http://89.108.115.241:6969/api/stocks';

        $result = file_get_contents('http://89.108.115.241:6969/api/stocks?dateTo=&page=1&key=E6kUTYrYwZq2tN4QEtyzsbEBk3ie&limit=100&dateFrom=2024-12-23');

        $sqlCreate = "create table if not exists data (";
        $data = json_decode($result,true)['data'][0];
        foreach ($data as $key => $value) {
            if(is_numeric($value)){
                $sqlCreate .= $key. " INT, ";
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
            $sqlInsert = 'insert into data (';
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
        return $sqlInsert;
    }
}
