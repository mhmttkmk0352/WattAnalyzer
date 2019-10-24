<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WattKiyas extends Controller
{
    public function wattekle(){
        $p["user_id"] = $_GET["u"];
        $p["cihaz_id"] = $_GET["c"];
        $p["voltaj"] = $_GET["v"];
        $p["amper"] = $_GET["a"];

        if (isset($p["user_id"]) && isset($p["cihaz_id"]) && isset($p["voltaj"]) && isset($p["amper"])){
            $c["cihaz_id"] = $p["cihaz_id"];
            $c["user_id"] = $p["user_id"];
            $c["cihaz_adi"] = "";
            $varmi = DB::table("watt_cihazlar")->where("user_id",$c["user_id"])->where("cihaz_id",$c["cihaz_id"])->get();
            
            if (count($varmi) != 1){
            
                DB::table("watt_cihazlar")->insert($c);
                echo 1;
            }
            else{
                echo 0;
            }

            $p["tarih"] = time();
            $p["watt"] = $p["voltaj"]*$p["amper"];
            DB::table("watt_karsilastir")->insert($p);

        }
        else{
            echo 0;
        }
        
    }
}




/*

http://localhost/dashboard/laravel/yeniX/public/wattekle?u=1%27a&c=24a4c&v=3.10&a=1

*/