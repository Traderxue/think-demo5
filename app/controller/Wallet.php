<?php

namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\wallet as WalletModel;
use app\util\Res;

class Wallet extends BaseController
{
    private $result;

    public function __construct(\think\App $app)
    {
        $this->result = new Res();
    }

    public function add(Request $request)
    {
        $postData = $request->post();
        $wallet = new WalletModel([
            "type" => $postData["type"],
            "amount" => $postData["amount"],
            "u_id" => $postData["u_id"]
        ]);
        $res = $wallet->save();
        if ($res) {
            return $this->result->success("添加数据成功", $wallet);
        }
        return $this->result->error("添加数据失败");
    }

    public function edit(Request $request)
    {
        $id = $request->post("id");
        $wallet = WalletModel::where("id", $id)->find();

        $type = $request->post("type");
        $amount = $request->post("amount");

        $res = $wallet->save([
            "type" => $type,
            "amount" => $amount
        ]);

        if ($res) {
            return $this->result->success("数据编辑成功", $res);
        }
        return $this->result->error("数据编辑失败");
    }

    public function getByUId($u_id)
    {
        $list = WalletModel::where("u_id", $u_id)->select();

        return $this->result->success("获取数据成功", $list);
    }

    public function delete($id)
    {
        $res  = WalletModel::where("id", $id)->delete();

        if ($res) {
            return $this->result->success("数据删除成功", null);
        }

        return $this->result->error("数据删除失败");
    }

    public function page(Request $request)
    {
        $page = $request->param("page", 1);
        $pageSize = $request->param("pageSize", 10);
        $type = $request->param("type");

        $list = WalletModel::where("type","like","%{$type}%")->paginate([
            "page"=>$page,
            "pageSize"=>$pageSize
        ]);

        return $this->result->success("获取数据成功",$list);
    }
}
