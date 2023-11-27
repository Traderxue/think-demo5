<?php
namespace app\controller;

use app\BaseController;
use think\Request;
use app\util\Res;
use app\model\Verify as VerifyModel;

class Verify extends BaseController{
    protected $result;

    public function __construct(){
        $this->result = new Res();
    }

    public function add(Request $request){
        $postData = $request->post();

        $v = VerifyModel::where("id_card",$postData["id_card"])->find();

        if($v){
            return $this->result->error("该身份证已绑定用户");
        }

        $verify = new VerifyModel([
            "name"=>$postData["name"],
            "id_card"=>$postData["id_card"],
            "u_id"=>$postData["u_id"],
            "add_time"=>date("Y-m-d H:i:s")
        ]);
        $res =$verify->save();
        if($res){
            return $this->result->success("添加数据成功",$verify);
        }
        return $this->result->error("数据添加失败");
    }

    public function edit(Request $request){
        $postData  = $request->post();
        $verify = VerifyModel::where("id",$postData["id"])->find();

        $res = $verify->save(["name"=>$postData["name"],"id_card"=>$postData["id_card"]]);

        if($res){
            return $this->result->success("编辑数据成功",$verify);
        }
        return $this->result->error("编辑数据失败");
    }

    public function delete($id){
        $res = VerifyModel::where("id",$id)->delete();

        if($res){
            return $this->result->success("删除成功",null);
        }
        return $this->result->error("删除数据失败");
    }

    public function getById($id){
        $verify = VerifyModel::where("id",$id)->find();

        if($verify){
            return $this->result->success("获取数据成功",null);
        }
        return $this->result->error("获取数据失败");
    }

    public function page(Request $request){
        $page = $request->param("page",1);
        $pageSize = $request->param("pageSize");
        $name = $request->param("name");

        $list = VerifyModel::where("name","like","%{$name}%")->paginate([
            "page"=>$page,
            "list_rows"=>$pageSize
        ]);

        return $this->result->success("获取数据成功",$list);
    }
}
