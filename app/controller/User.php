<?php

namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\User as UserModel;
use app\util\Res;

class User extends BaseController
{
    private $result;

    public function __construct()
    {
        $this->result = new Res();
    }

    public function add(Request $request)
    {
        $postData = $request->post();
        $u = UserModel::where("username", $postData["username"])->find();

        if ($u) {
            return $this->result->error("用户已存在");
        }

        $user = new UserModel([
            "username" => $postData["username"],
            "password" => password_hash($postData["password"], PASSWORD_DEFAULT),
            "add_time" => date("Y-m-d H:i:s"),
        ]);
        $res = $user->save();
        if ($res) {
            return $this->result->success("添加数据成功", $res);
        }
        return $this->result->error("添加数据失败");
    }

    public function edit(Request $request)
    {
        $postData = $request->post();

        $user = UserModel::where("id", $postData["id"])->find();

        $res = $user->save(["balance" => $postData["balance"], "permission" => $postData["permission"], "credit" => $postData["credit"]]);

        if ($res) {
            return $this->result->success("编辑数据成功", $res);
        }
        return $this->result->error("编辑数据失败");
    }

    public function prohibit(Request $request)
    {
        $id = $request->post("id");
        $state = 0;

        $user = UserModel::where("id", $id)->find();

        $user->save(["state" => $state]);

        if ($user) {
            return $this->result->success("禁用用户成功", $user);
        }
        return $this->result->error("禁用用户失败");
    }

    public function deleteById($id)
    {
        $res = UserModel::where("id", $id)->delete();
        if ($res) {
            return $this->result->success("删除数据成功", $res);
        }
        return $this->result->error("删除数据失败");
    }

    public function page(Request $request)
    {
        $page = $request->param("page", 1);
        $pageSize = $request->param("pageSize", 10);
        $username = $request->param("username");

        $list = UserModel::where("username", "like", $username)->paginate([
            "page" => $page,
            "list_rows" => $pageSize
        ]);

        return $this->result->success("获取数据成功", $list);
    }

    public function getById($id)
    {
        $user = UserModel::where("id", $id)->find();
        if($user){
            return $this->result->success("获取数据成功",$user);
        }
        return $this->result->error("获取数据失败");
    }
}
