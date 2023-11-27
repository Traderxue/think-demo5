<?php
namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\Coin as CoinModel;
use app\util\Res;

class Coin extends BaseController{
    private $result;
    public function __construct(){
        $this->result = new Res();
    }

    public function add(Request $request){
        $postData = $request->post();

        $c = CoinModel::where("type",$postData["type"])->find();

        if($c){
            return $this->result->error("币种已存在");
        }

        $coin = new CoinModel([
            "type"=>$postData["type"],
            "add_time"=>date("Y-m-d H:i:s")
        ]);
        $res = $coin->save();

        if($res){
            return $this->result->success("添加数据成功",$coin);
        }
        return $this->result->error("添加数据失败");
    }

    public function delete($id){
        $res = CoinModel::where("id",$id)->delete();
        if($res){
            return $this->result->success("删除数据成功",$res);
        }
        return $this->result->error("删除数据失败");
    }

    public function get(){
        $list = CoinModel::select();
        return $this->result->success("获取数据成功",$list);
    }

    public function page(Request $request){
        $page = $request->param("page",1);
        $pageSize = $request->param("pageSize",10);
        $type = $request->param("type");

        $list = CoinModel::where("type","like","%{$type}%")->paginate([
            "page"=>$page,
            "list_rows"=>$pageSize
        ]);

        return $this->result->success("获取数据成功",$list);
    }
}