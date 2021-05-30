<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public static function insertData($data){

        DB::table('csv_file')->insert([
         'file_name' =>  $data['file_name'] ,
         'number_of_lines' => $data['number_of_lines']
       ]); 
     }
}
