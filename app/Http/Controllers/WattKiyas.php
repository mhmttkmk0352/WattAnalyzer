<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
class WattKiyas extends Controller
{

    public function wattekle_ekstra($user_id, $p){

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
    
                    $this->wattekle_ekstra($user_id, $p);

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

http://localhost/dashboard/laravel/yeniX/public/wattekle?e=mehmet.tkmk.0352@gmail.com&p=12341234&c=Kayseri&v=210&a=6

*/