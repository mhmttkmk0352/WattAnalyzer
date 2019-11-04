<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
class WattKiyas extends Controller
{
    //public $nodejsServer = "http://localhost:3000/";
    public $filterSeconds = 20;

    public function wattekle_ekstra($user_id, $p,  $val){

        $suan = time();
        if (isset($p["cihaz_id"]) && isset($p["voltaj"]) && isset($p["amper"])){
            $c["cihaz_id"] = $p["cihaz_id"];
            $c["user_id"] = $user_id;
            $c["cihaz_adi"] = "";



            unset($p["email"]);
            unset($p["parola"]);




            $varmi = DB::table("watt_cihazlar")->where("user_id", $c["user_id"])->where("cihaz_id",$c["cihaz_id"])->get();
       
            if (count($varmi) != 1){
            
                DB::table("watt_cihazlar")->insert($c);
                echo "Cihaz Eklendi";
                echo "<br>\r\n";
            }
            else{
                echo "Cihaz zaten ekliydi";
            }

            $p["tarih"] = time();
            $p["watt"] = $p["voltaj"]*$p["amper"];
            DB::table("watt_karsilastir")->insert($p);

            echo "<br>\r\n";

/* BAŞLANGIÇ */
            $differenceCount = 0;
            $tumu = DB::table("watt_cihazlar")->where("user_id", $c["user_id"])->get();
            if (isset($tumu)){
                if(count($tumu)>0){
                    foreach($tumu as $k=>$v){
                        $chz_id = $v->cihaz_id;
                        if ($chz_id != $p["cihaz_id"]){
                            $t_cek = DB::table("watt_karsilastir")->select("*")->where("user_id", $c["user_id"])->where("cihaz_id",$v->cihaz_id)->get()->last();
                            //print_r($t_cek);
                            if( isset($t_cek) && isset($t_cek->tarih) ){
                                $diff = ($suan)-($t_cek->tarih);
                                if($diff>$differenceCount){
                                    $differenceCount= $diff;
                                }
                            }
   
                        }

                        
                    }
                    echo "diff: ";
                    echo $differenceCount; 
                    if($differenceCount < $this->filterSeconds){
                       echo "Kaydet";
                       echo "<br>\r\n";
     
                      
                        $w = DB::table("watt_eszamanli")->select("*")->get();

                        $jsn = [];
                        foreach($tumu as $k=>$v){

                            $chz_id = $v->cihaz_id;
                            $t_cek = DB::table("watt_karsilastir")->select("*")->where("user_id", $c["user_id"])->where("cihaz_id",$v->cihaz_id)->get()->last();
                            $chz_inf = array( "user_id"=>$t_cek->user_id, "cihaz_id"=>$t_cek->cihaz_id, "voltaj"=>$t_cek->voltaj, "amper"=>$t_cek->amper, "watt"=>$t_cek->watt, "tarih"=>$t_cek->tarih );
                            //DB::table("watt_eszamanli")->insert($chz_inf);

                            $jsn[$t_cek->cihaz_id]["user_id"] = $t_cek->user_id;
                            $jsn[$t_cek->cihaz_id]["cihaz_id"] = $t_cek->cihaz_id;
                            $jsn[$t_cek->cihaz_id]["voltaj"] = $t_cek->voltaj;
                            $jsn[$t_cek->cihaz_id]["amper"] = $t_cek->amper;
                            $jsn[$t_cek->cihaz_id]["watt"] = $t_cek->watt;
                            $jsn[$t_cek->cihaz_id]["tarih"] = $t_cek->tarih;

                        }
                       
                        $jsnInsert = array("user_id"=>$user_id, "anlikdeger"=>json_encode($jsn), "tarih"=>time());
                        $jsnAdet = count($jsn);
                        
                        if ($jsnAdet && $jsnAdet<2){
                            echo "<br>\r\n";
                            echo "Tek taraflı veri sebebiyle ekleme yapılamadı ( ".$this->filterSeconds." )";
                            echo "<br>\r\n";
                            echo "<br>\r\n"; 
                            exit();                                 
                        }

                        $sonEsZamanliVeriGetir = DB::table("watt_eszamanli")->select("tarih")->get()->last();
                     
                        if ( isset($sonEsZamanliVeriGetir) && isset($sonEsZamanliVeriGetir->tarih) && is_numeric($sonEsZamanliVeriGetir->tarih) ){

                            $suanSonFarki = $suan-$sonEsZamanliVeriGetir->tarih;
                            echo $suanSonFarki;
                            echo "<br>";
                                
                            if ($suanSonFarki > $this->filterSeconds){
                
                                DB::table("watt_eszamanli")->insert($jsnInsert);

                                echo "<br>\r\n";
                                echo "Eş zamanlı tablo eklemesi başarılı ( ".$this->filterSeconds." )";
                                echo "<br>\r\n";
                                echo "<br>\r\n";                          
                
                
                            }//if ($suanSonFarki > $this->filterSeconds)
                            else{
                                echo "Üst üste veri girmezsiniz";
                                exit();
                            }                                

                        }
                        else{
                            DB::table("watt_eszamanli")->insert($jsnInsert);

                            echo "<br>\r\n";
                            echo "Eş zamanlı tablo eklemesi başarılı ( ".$this->filterSeconds." )";
                            echo "<br>\r\n";
                            echo "<br>\r\n";                                
                        }

                        

                    }
                    else{
                        echo "<br>\r\n";
                        echo "Zaman Aşımı Sebebiyle ekleme yapılamadı: limit ( ".$this->filterSeconds." )";
                        echo "<br>\r\n";
                        echo "<br>\r\n";
                    }  //END if ($suanSonFarki > $this->filterSeconds)                 
                }
            }
/* BİTİŞ */





    
        }
        else{
            echo 0;
        }        
    }


    public function wattekle(){

        $p["email"] = $_GET["e"];
        $p["parola"] = $_GET["p"];



        $val = DB::table("users")->select("id","password")->where("email", $p["email"])->get();

    

   

        if (isset($val)){

                $user_id = $val[0]->id;
                $password = $val[0]->password;
                $durum = Hash::check( $p["parola"],  $password);

                if ($durum == 1){

                    echo "Kullanıcı Bilgileri Doğru: ".$durum;
                    echo "<br>\r\n";
     
                    $p["user_id"] = $user_id;
                    $p["cihaz_id"] = $_GET["c"];
                    $p["voltaj"] = $_GET["v"];
                    $p["amper"] = $_GET["a"];
    
                    $this->wattekle_ekstra($user_id, $p, $val);

                }
                else{
                    echo "Kullanıcı Bilgileri Yanlış: ".$durum;
                    echo "<br>\r\n";                    
                }

        }
        else{
            echo "Eşleşme yok";
            exit();
        }
    }
}




/*

http://localhost/dashboard/laravel/yeniX/public/wattekle?e=mehmet.tkmk.0352@gmail.com&p=12341234&c=talas&v=200&a=12

*/