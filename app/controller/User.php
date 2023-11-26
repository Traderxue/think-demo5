<?php
namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\User as UserModel;
use app\util\Res;

class User extends BaseController{
    private $result;

    public function __construct(){
        $this->result = new Res();
    }
}