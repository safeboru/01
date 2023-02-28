<?php
//声明命名空间
namespace Admin\Controller;
//引入父类
use Think\Controller;
//声明类并且继承父类
class DocController extends Controller{

    //showList
    public function showList(){
        //查询数据
        $model = M('Doc');
        //查询全部
        $data = $model -> select();
        //传递给模板
        $this -> assign('data',$data);

        //展示模板
        $this -> display();
    }

    //add
    public function add(){
        if(IS_POST){
            //处理提交
            $post = I('post.');
            //补全addtime字段
            $post['addtime'] = time();
            //实例化模型
            $model = M('Doc');//这里关联的是表
            //提交数据到数据库
            $result = $model -> add($post);
            //判断保存结果
            if($result){
                //成功
                $this -> success('添加成功',U('showList'),3);
            }else{
                //失败
                $this -> error('添加失败');//添加失败 肯定是返回上一页继续添加 这里默认参数就是上一页（如果跳转到上一页就不用传递参数）
            }
        }else{

            //从session查出username然后放到页面上
            $this -> assign('username',session('username'));
            //展示模板
            $this -> display();
        }
    }

}