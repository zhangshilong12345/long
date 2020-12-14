<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use liliuwei\think\Jump;
use think\facade\Db;
use think\facade\View;
use think\Request;

class glass extends BaseController
{
    use Jump;
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //文章上传返回的表单
        return View::fetch("register");
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //添加文章的方法
        $register=[
            "username"=>$request->post("username"),
            "miao"=>$request->post("miao"),
            "rong"=>$request->post("rong")
        ];
        $file=$request->file("img");
        if($file) {
            $image=\think\facade\Filesystem::disk('public')->putFile( 'topic', $file);
            $register["img"]="/storage/".$image;
        }

        //对文章标题做验证
        if(strlen($register['username'])>50){
            die('标题太大,请重新输入');
        }

        if(Db::table("registers")->insert($register)){
            $this->success("注册成功","glass/list");
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function list()
    {
        //这是文章列表展示的页面
        $listFile=Db::table('registers')->order('sort','desc')->paginate(10);
        View::assign("list",$listFile);

        return View::fetch("list");
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function del($id)
    {
        //这是删除的效果
        if(empty($id)){
            die('id不能为空');
        }
        if(Db::table('registers')->delete($id)){
            $this->success("删除成功","glass/list");
        }
    }
}
