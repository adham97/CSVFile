<?php

namespace App\Http\Controllers;

use Session, Response;
use Illuminate\Http\Request;
use App\Models\Page;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    
    public function index(){
        return view('index');
    }

    public function uploadFile(Request $request){

        $file = $request->file('file');
        $csv_file = $request->file('file');

        // File Details 
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");

        // 2MB in Bytes
        $maxFileSize = 2097152; 

        // Check file extension
        if(in_array(strtolower($extension),$valid_extension)){

            // Check file size
            if($fileSize <= $maxFileSize){

            // File upload location
            $location = 'uploads';

            // Upload file
            $file->move($location,$filename);

            // Import CSV to Database
            $filepath = public_path($location."/".$filename);

            // Reading file
            $file = fopen($filepath,"r");

            $importData_arr = array();
            $i = 0;

            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata );
                for ($c=0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata [$c];
                }
                $i++;
            }
            fclose($file);

            // Call Flask API To Insert Data user from csv File to MySQL database
            foreach($importData_arr as $importData){
                $responseUser = Http::post('http://localhost:5000/insertUser', [
                    "name"=>$importData[0],
                    "gender"=>$importData[1],
                    "email"=>$importData[2]
                ]);
            }

            $number_of_lines = $i;

            // Call Flask API To Insert csv file to MySQL database
            $responseFile = Http::post('http://localhost:5000/insertFile', [
                'csv_file' => $csv_file,
                'file_name' => $filename, 
                'number_of_lines' => $number_of_lines
            ]);
            
            Session::flash('message','Import Successful.');
            
            // Select inserted file
            $response = Http::get('http://localhost:5000/');

            return $response;

            } else {
                Session::flash('message','File too large. File must be less than 2MB.');
            }

        } else{
            Session::flash('message','Invalid File Extension.');
        }

    // Redirect to index
    return 'hi';//redirect()->action('PagesController@index');
  }
}