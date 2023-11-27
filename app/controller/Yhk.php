<?php

namespace app\controller;

use app\BaseController;
use app\model\Yhk as YhkModel;
use think\Request;
use app\util\Res;


class Yhk extends BaseController
{
    protected $result;

    public function __construct()
    {
        $this->result = new Res();
    }

    public function add(Request $request){
        $postData = $request->post();

        $yhk = new YhkModel([
            "phone"=>$postData["phone"],
            "card"=>$postData["card"],
            "add_time" =>date("Y-m-d H:i:s"),
            "u_id" => $postData["u_id"]
        ]);
        $res = $yhk->save();

        if($res){
            return $this->result->success("数据添加成功",$yhk);
        }
        return $this->result->error("数据添加失败");
    }

    public function edit(Request $request){
        $id = $request->post("id");
        $phone = $request->post("phone");
        $card = $request->post("card");

        $yhk = YhkModel::where("id",$id)->find();

        $res = $yhk->save([
            "phone"=>$phone,
            "card"=>$card
        ]);

        if($res){
            return $this->result->success("数据编辑成功",$yhk);
        }
        return $this->result->error("数据编辑失败");
    }

    public function delete($id){
        $res = YhkModel::where("id",$id)->delete();

        if($res){
            return $this->result->success("删除数据成功",$res);
        }   
        return $this->result->error("删除数据失败");
    }

    public function getByUId($u_id){
        $list = YhkModel::where("u_id",$u_id)->select();

        return $this->result->success("获取数据成功",$list);
    }

    public function page(Request $request){
        $page = $request->param("page",1);
        $pageSize= $request->param("pageSize",10);

        $list = YhkModel::paginate([
            "page"=>$page,
            "list_rows"=>$pageSize
        ]);

        return $this->result->success("获取数据成功",$list);
    }
}