<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainDB extends Model
{
    public function MainDBnotlistele(){
        $R = DB::table("datatablenotlistele")->get();
        return $R;
    }
}
