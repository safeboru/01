<?php
//声明命名空间
namespace Admin\Controller;
//引入父类控制器
use Think\Controller;
//声明类并且继承父类
class PublicController extends Controller{

    //登录页面展示
    public function login(){
        //展示模板
        $this->display();
        //获取模板内容
        //$str = $this->fetch();
        //dump打印
        //echo $str;
    }

    //captcha方法
    public function captcha(){
        //配置
        $cfg = array(
            'fontSize'  =>  12,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'imageH'    =>  38,
            'imageW'    =>  90,
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
        );
        //实例化验证码类
        $vetify = new \Think\Verify($cfg);
        //输出验证码
        $vetify -> entry();
    }

    //checkLogin
    public function checkLogin(){
        //接收数据
        $post = I('post.');
        //验证验证码（不需要传参）
        $verify = new \Think\Verify();
        //验证
        $result = $verify -> check($post['captcha']);
        //判断验证码是否正确
        if($result){
            //验证码正确，继续处理用户名和密码
            $model = M('User');
            //删除验证码元素
            unset($post['captcha']);
            $data = $model -> where($post) -> find();
            //判断是否存在用户
            if($data){
                //存在用户 用户信息持久化保存到session中 跳转到后台首页
                session('id',$data['id']);
                session('username',$data['username']);
                session('role_id',$data['role_id']);
                //跳转到后台首页
                $this -> success('登录成功ovo',U('Index/index'),3);//U方法跳转到Index控制器的index方法
            }else{
                //不存在
                $this -> error('用户名或密码错误..');
            }
        }else{
            //验证码不正确
            $this -> error('您输入的验证码错误！');//没有参数的话 默认就跳转上一页
        }
    }

    //退出方法
    public function logout(){
        //清除session
        session(null);
        //跳转到登录页面
        $this -> success('退出成功',U('login'),3);
    }
}
