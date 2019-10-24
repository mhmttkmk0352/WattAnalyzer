<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public $arrData = [];

    public function DevicesLastData($user_id, $cihaz_id, $olayLimiti){

      $p = DB::table("watt_karsilastir")->where("user_id", $user_id)->where("cihaz_id", $cihaz_id)->orderBy("id","DESC")->limit($olayLimiti)->get();
 
      foreach($p as $k=>$v){
        $w[$k] = $v->watt;
      }
      $w = array_reverse($w);
      return $w;
      
    } 



    public function Average($user_id, $cihaz_id){
          $avgValue = DB::table("watt_karsilastir")->select("watt")->where("user_id", $user_id)->where("cihaz_id", $cihaz_id)->get()->avg("watt");
          return round($avgValue,1);
    }


    public function index()
    {
      $olayLimiti = 4;
      $data["deviceValuesCount"] = 0;
      $data["datasets"] = "";
      
      $user_id = Auth::user()->id;
      if (isset($user_id)){
        if (is_numeric($user_id)){
          $deviceLists = DB::table("watt_cihazlar")->where("user_id", $user_id)->get();
          if (isset($deviceLists)){
            if ( sizeof($deviceLists)>0 ){



              $data["device_piece"] = count($deviceLists);
              $data["deviceLists"] = $deviceLists;


              /* DATA DEĞERLERİ TOPLAMA ALANI */
              
              

              /* CHARTJS RENK TANIMLAMALARI BAŞLANGIÇ*/
              
              $backgroundColor = 
              [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
              ];
              $borderColor = 
              [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
              ];

              /* CHARTJS RENK TANIMLAMALARI BİTİŞ*/


              foreach($deviceLists as $k=>$v){
                $datasets[$k]["avgValue"] = $this->Average($user_id, $v->cihaz_id);
                $datasets[$k]["label"] = $v->cihaz_id;
                $datasets[$k]["data"] = $this->DevicesLastData($user_id, $v->cihaz_id, $olayLimiti);
                $datasets[$k]["backgroundColor"] = $backgroundColor[$k];
                $datasets[$k]["borderColor"] = $borderColor[$k];
                $datasets[$k]["borderWidth"] = 1;
                
                // Bu kısım cihaz değerlerinin en yüksek olanını alıp Charts'e dengeli bir şekilde aktarmak içindir.
                if ( count($datasets[$k]["data"]) > $data["deviceValuesCount"] ){
                    $data["deviceValuesCount"] = count($datasets[$k]["data"]);
                }
              }

              if (isset($datasets)){
                  foreach($datasets as $k=>$v){
                    
                    $fark = $data["deviceValuesCount"] - count($v["data"]);
                    if ( $fark == 0  ){

                    }
                    else{
                      for($i=0; $i<$fark; $i++){
                           array_unshift($datasets[$k]["data"], 0);          
                      }
                     
                      
                    }
                  }
              }
              
              $data["datasets"] = json_encode($datasets);  
            }
          }
  
          
        }
      }


      
 

        //$data["allnotes"] = DB::table("allnotes")->select("users.id","users.name","note_title", "note_description", "note_date")->join("users", "users.id", "=", "allnotes.user_id")->get();

        return view('home', array("data"=>$data));
    
    }



  

    
}
