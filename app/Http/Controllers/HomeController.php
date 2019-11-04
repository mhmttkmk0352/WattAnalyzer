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

    public $backgroundColor = 
    [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)'
    ];
    public $borderColor = 
    [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(255, 159, 64, 1)'
    ];  



    public function DevicesLastData($user_id, $cihaz_id, $olayLimiti){

      $p = DB::table("watt_karsilastir")->where("user_id", $user_id)->where("cihaz_id", $cihaz_id)->orderBy("id","DESC")->limit($olayLimiti)->get();
      $w = array();
      foreach($p as $k=>$v){
        $w[$k] = $v->watt;
      }
      $x = array_reverse($w);
      return $x;
      
    } 



    public function Average($user_id, $cihaz_id){
          $avgValue = DB::table("watt_eszamanlikarsilastir")->select("watt")->where("user_id", $user_id)->where("cihaz_id", $cihaz_id)->get()->avg("watt");
          return round($avgValue,1);
    }


    public function eszamanliVerileriGetir($user_id, $olayLimiti){
      $c = DB::table("watt_eszamanli")->where("user_id", $user_id)->orderBy("id", "DESC")->limit($olayLimiti)->get();
      
      $anlik = [];

      if (isset($c)){
        if (count($c)>0){
          foreach($c as $k=>$v){
            if ( isset($v->anlikdeger) ){
              $anlikdeger = json_decode($v->anlikdeger);
              if ( isset($anlikdeger) ){
                
                foreach($anlikdeger as $k=>$v){
                  $anlik[$v->user_id][$v->cihaz_id]["watt"][] = $v->watt;
                
                }
                
              }
            }
          }
        }
      }

      /* Anlık değerlerin bulunduğu diziyi(array) ters çevir*/
      if ( isset($anlik) ){
        if ( count($anlik)>0 ){
       
          foreach($anlik as $k=>$v){
            
            if ( isset($v) ){
              if ( count($v)>0 ){
                foreach($v as $kk=>$vv){
                  
                  $watt = array_reverse($vv["watt"]);
                  $anlik[$user_id][$kk]["watt"] = $watt;
                }
              }
            }
            echo "<br>";
          }
        }
      }

      $o = array("es"=>$c, "anlikDegerler"=>$anlik);
      return $o;
    }


    public function index()
    {
      $data["datasetsIlk"] = "";
      $data["datasets"] = "";

      $olayLimiti = 10;
      $data["deviceValuesCount"] = 0;
      $data["datasets"] = "";
      
      $user_id = Auth::user()->id;
 
      if (isset($user_id)){
        $eszamanCikti = $this->eszamanliVerileriGetir($user_id, $olayLimiti);
        $es = $eszamanCikti["es"];
        if ( isset($es) ){
          if ( count($es)>0 ){
       
            foreach($es as $k=>$v){
           
              if ( isset($v->anlikdeger) ){
                $jsondecode = json_decode($v->anlikdeger); 
              
                if ( isset($jsondecode) ){
                  $say = 0;
                  foreach( $jsondecode as $kk=>$vv ){
                    $datasetsIlk[$say]["label"] = $kk;
                    $datasetsIlk[$say]["data"] = $eszamanCikti["anlikDegerler"][$user_id][$kk]["watt"];
                    $datasetsIlk[$say]["backgroundColor"] = $this->backgroundColor[$say];
                    $datasetsIlk[$say]["borderColor"] = $this->borderColor[$say];
                    $datasetsIlk[$say]["borderWidth"] = 1;
                    $say++;
                  }
                }

              }

            }
          }
        }

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
                $datasets[$k]["backgroundColor"] = $this->backgroundColor[$k];
                $datasets[$k]["borderColor"] = $this->borderColor[$k];
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

              if ( isset($datasetsIlk) ){
                $data["datasetsIlk"] = json_encode($datasetsIlk);
              }
              else{
                $data["datasetsIlk"] = "";
              }

              if ( isset($datasets) ){
                $data["datasets"] = json_encode($datasets);
              }
              else{
                $data["datasets"] = "";
              }

            }
          }
  
          
        }
      }


      
 

        //$data["allnotes"] = DB::table("allnotes")->select("users.id","users.name","note_title", "note_description", "note_date")->join("users", "users.id", "=", "allnotes.user_id")->get();

        return view('home', array("data"=>$data));
    
    }



  

    
}
