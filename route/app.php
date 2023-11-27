<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


Route::group("/user", function () {

    Route::post("/add", "user/add");

    Route::post("/edit", "user/edit");

    Route::post("/pro", "user/prohibit");        //禁用

    Route::delete("/delete/:id", "user/deleteById");

    Route::get("/page", ".user/page");

    Route::get("/get/:id", "user/getById");

    Route::post("/transfer", "user/transfer");
});

Route::group("/coin", function () {

    Route::post("/add", "coin/add");

    Route::delete("/delete/:id", "coin/delete");

    Route::get("/get","coin/get");

    Route::get("/page","coin/page");
});

Route::group("/verify",function(){

    Route::post("/add","verify/add");

    Route::post("/edit","verify/edit");

    Route::delete("/delete/:id","veridy/delete");

    Route::get("/get/:id","verify/getById");

    Route::get("/page","verify/page");
});

Route::group("/yhk",function(){

    Route::post("/add","yhk/add");

    Route::post("/edit","yhk/edit");

    Route::delete("/delete/:id","yhk/delete");

    Route::get("/get/:u_id","yhk/getByUId");

    Route::get("page","yhk/page");
});

Route::group("/wallet",function(){

    Route::post("/add","wallet/add");

    Route::post("/edit","wallet/edit");
    
    Route::get("/get/:u_id","wallet/getByUId");

    Route::delete("/delete/:id","wallet/delete");

    Route::get("/page","wallet/page");
});