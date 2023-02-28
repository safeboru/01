<?php
//声明命名空间
namespace Admin\Controller;
//引入父类控制器
use Think\Controller;
use Think\Verify;
//声明并且继承父类控制器
class TestController extends Controller{

    public function test(){
        //输出
//        echo 'Hello world';
        //定义变量
        $var = date('Y-m-d H:i:s',time());
        //变量分配
        $this->assign('var',$var);
        //展示模板
        $this->display();
    }

    public function test1(){
        echo U('index');
        //展示模板
        $this->display("test");
    }

    public function test2(){
        echo U('Index/index');
        //展示模板
        $this->display('Demo/test');
    }

    public function test3(){
        echo U('Index/index',array('id' => 10));
    }

    public function test4(){
        //成功跳转
        $this->success('操作成功',U('test'),10);
    }

    public function test5(){
        //失败跳转
        $this->error('您人品有问题',U('test1'),10);
    }

    public function test6(){
        //模板常量的展示
        $this->display();
    }

    //视图注释
    public function test7(){
        //展示模板
        $this->display();
    }

    //变量的输出（数组）
    public function test8(){
        //定义一维数组
        $array = array('西游记','三个女人和105个男人的故事','一个男人和一堆女人的故事','三国演义');
        //定义二维数组
        $array2 = array(
            array('白骨精','大师兄','二师兄','沙师弟'),
            array('松江','孙二娘','林冲','李逵'),
            array('贾宝玉','刘姥姥','薛宝叉','林黛玉'),
            array('孙枣','鲁大师','孙小虎','术爸'),
        );
        //变量的分配
        $this->assign('array',$array);
        $this->assign('array2',$array2);
        //展示模板
        $this->display();
    }

    //变量分配（对象）
    public function test9(){
        //实例化student对象
        $stu = new Student();
        //给类的属性赋值
        $stu-> id = 100;
        $stu-> name = '马冬梅';
        $stu-> sex = '女';
        //变量的分配
        $this->assign('stu',$stu);
        //展示模板
        $this->display();
    }

    //系统变量
    public function test10(){
        //展示模板
        $this->display();
    }

    //模板中函数使用
    public function test11(){
        //定义时间戳
        $time = time();
        //定义字符串
        $str = 'AbcDEfgjwjns';
        //传递给模板
        $this->assign('time',$time);
        $this->assign('str',$str);
        //展示模板
        $this->display();
    }

    //默认值
    public function test12(){
        //定义一个空的字符串
        $sign = '';
        //$sign = $sign ? : '这个家伙很懒...';
        //传递给模板
        $this->assign('sign',$sign);
        //展示模板
        $this->display();
    }

    //运算符
    public function test13(){
        //定义两个变量
        $a = 100;
        $b = 10;
        //传递给模板
        $this->assign('a',$a);
        $this->assign('b',$b);
        //展示模板
        $this->display();
    }

    //展示头部
    public function head(){
        //展示模板
        $this->display();
    }

    //展示body
    public function body(){
        //展示模板
        $this->display();
    }

    //展示尾部
    public function foot(){
        //展示模板
        $this->display();
    }

    //数组遍历
    public function test14(){
        //定义一维数组
        $array = array(
            '西游记',
            '三个女人和105个男人的故事',
            '一个男人和一堆女人的故事',
            '三国演义'
        );
        //定义二维数组
        $array2 = array(
            array('白骨精','大师兄','二师兄','沙师弟'),
            array('松江','孙二娘','林冲','李逵'),
            array('贾宝玉','刘姥姥','薛宝叉','林黛玉'),
            array('孙枣','鲁大师','孙小虎','术爸'),
        );
        //传递给模板
        $this->assign('array',$array);
        $this->assign('array2',$array2);
        //展示模板
        $this->display();
    }

    //if标签
    public function test15(){
        //输出今天的星期数字
        $day = date('N',time());
        //传递给模板
        $this->assign('day',$day);
        $this->display();
    }

    //php标签
    public function test16(){
        //展示模板
        $this->display();
    }

    //sql调试
    public function test17(){
        //实例化模型
        $model = M('Dept');
        //查询
        $data = $model -> select();//查询全部
        //获取sql语句
        echo $model -> _sql();
    }

    //性能测试
    public function test18(){
        //定义开始标记
        G('start');
        for($i=0; $i < 100000000; $i++){
            echo $i;
        }
        //结束标记
        G('stop');
        echo "<hr/>";
        //统计开始
        echo G('start','stop',4);
    }

    //AR模式增加操作
    public function test19(){
        //第一个映射：类映射表（类关联表）
        $model = M('Dept');
        //第二个映射：属性映射字段
        $model -> name   = '技术部';
        $model -> pid    = '0';
        $model -> sort   = '10';
        $model -> remark = '技术部门最重要';
        dump($model);die();
        //第三个映射：实例映射记录
        $result = $model -> add(); //没有参数
        dump($result);
    }

    //AR模式修改操作
    public function test20(){
        //实例化模型
        $model = M('Dept');
        //属性映射到字段
        $model -> id     = '2';//确定主键信息
        $model -> name   = '法务部';
        $model -> remark = 'this is fawubu';
        //修改操作
        $result = $model -> save();
        //打印
        dump($result);
    }

    //AR模型删除操作
    public function test21(){
        //实例化模型
        $model = M('Dept');
        //指定主键信息
        $model -> id = '8,10';//属性可以指定1个主键也可以指定多个主键
        //执行删除操作
        $result  = $model -> delete();
        //打印
        dump($result);
    }

    //AR模式可以不指定主键信息
    public function test22(){
         //实例化模型
        $model = M('Dept');
        //查询
        $data  = $model -> find(11);
        //修改
//        $model -> pid = '1';
//        $result = $model -> save();
        //删除
        $result = $model -> delete();
        dump($result);
    }

    //where方法
    public function test23(){
        //实例化模型
        $model = M('Dept');
        //查询
        $model -> where('id > 2');//条件where id  > 2
        dump($model);die();
        $data = $model -> select();
        dump($data);
    }

    //limit方法
    public function test24(){
        //实例化模型
        $model = M('Dept');
        //限制记录
        //第一种，查询前n条
        $model -> limit(3);
        $data = $model -> select();
        //第二种：查询带偏移量的形式
        $model -> limit(1,3);
        $data = $model -> select();
        //打印
        dump($data);
    }

    //field方法
    public function test25(){
        //实例化模型
        $model = M('Dept');
        //限制字段
        $model -> field('id,name,remark');
        //查询
        $data = $model -> select();
        //打印
        dump($data);
    }

    //order方法
    public function test26(){
        //实例化模型
        $model = M('Dept');
        //order排序
        $model -> order('id DESC'); //按照id 降序排序
        //查询
        $data = $model -> select();
        //打印
        dump($data);
    }

    //group方法
    public function test27(){
        //实例化模型
        $model = M('Dept');
        //group分组
        $model -> group('name'); //按照部门 分组
        //限制查询限制
        $model -> field('name,count(id) as count');
        //查询
        $data = $model -> select();
        //打印
        dump($data);
    }

    //连贯操作
    public function test28(){
        //实例化模型
        $model = M('Dept');
        //连贯操作
        $data = $model -> field('name,count(id) as count') -> group('name') -> select();
        //打印
        dump($data);
    }

    //count
    public function test29(){
        //实例化模型
        $model = M('Dept');
        //查询
        $count = $model -> count();
        dump($count);
    }

    //max
    public function test30(){
        //实例化模型
        $model = M('Dept');
        //查询最大值
        $max = $model -> max('id');
        dump($max);
    }

    //min
    public function test31(){
        //实例化模型
        $model = M('Dept');
        //查询最小值
        $min = $model -> min('id');
        dump($min);
    }

    //avg
    public function test32(){
        //实例化模型
        $model = M('Dept');
        //求平均值
        $avg = $model -> avg('id');
        dump($avg);
    }

    //sum
    public function test33(){
        //实例化模型
        $model = M('Dept');
        //求总和
        $sum = $model -> sum('id');
        dump($sum);
    }

    //fetchSql
    public function test34(){
        //实例化模型
        $model = M('Dept');
        //连贯操作
        $data = $model -> field('name,count(*) as count') -> fetchSql(true) -> group('name') -> select();
        dump($data);
    }

    //特殊类的实例化
    public function test35(){
        //实例化
        $model = D('Szphp');
        dump($model);
    }

    //session
    public function test36(){
        //1、设置
        session('name','王哲');
        session('name2','小兔子');
        dump($_SESSION);
        //2、读取单个
        $value = session('name');
        dump($value);
        //3、清空单个
        session('name',null);
        dump($_SESSION);
        //4、全部删除
        session('name3','马冬梅');
//        session(null);
//        dump($_SESSION);
        //5、读取全部
        dump(session());
        //6、判断某个session是否存在
        dump(session('?name3'));
    }

    //cookie
    public function test37(){
        //1、设置没有有效期的cookie
        cookie('name','xialo');
        //2、设置带有有效期的cookie
        cookie('name2','shashibiya',3600);
        //3、获取单个cookie值
        dump(cookie('name2'));
        //4、清空指定的cookie
        cookie('name',null);
        //5、清空全部
//        cookie(null); //有问题的
        //6、获取全部
        dump(cookie());
    }

    //调用函数库文件
    public function test38(){
        //使用函数
        gbk2utf8();
    }

    //测试load_ext_file引入
    public function test39(){
        //使用函数
        getInfo();
    }

    //load方法
    public function test40(){
        //load
        load('@/hello');
        //调用函数
        sayhello('world');
    }

    //常规验证码
    public function test41(){
        //配置
        $config = array(
            'fontSize'  =>  12,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
        );
        //实例化验证码类
        $verify = new Verify($config);
        //输出验证码
        $verify -> entry();
    }

    //中文验证码
    public function test42(){
        //配置
        $config = array(
            'useZh'     =>  true,           // 使用中文验证码
            'fontSize'  =>  12,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'length'    =>  4,               // 验证码位数
        );
        //实例化验证码类
        $verify = new Verify($config);
        //输出图片
        $verify -> entry();
    }

    //table方法联表查询
    // SELECT t1.*,t2.name AS deptname
    //FROM sp_user AS t1,sp_dept AS t2
    //WHERE t1.`dept_id` = t2.`id`; （这个就是table方法联表查询 并不是真的有table关键字）
    public function test43(){
        //实例化模型
        $model = M();//因为要关联两张表 所以这里写不了两张表 （执行原生的sql语句可以不要关联表）

        //定义sql语句
//        $sql = "SELECT t1.*,t2.name AS deptname FROM sp_user AS t1,sp_dept AS t2 WHERE t1.`dept_id` = t2.`id`;";

//        $result = $model -> query($sql); //执行之后有返回结果

        $result = $model -> field('t1.*,t2.name AS deptname')
                        -> table('sp_user AS t1,sp_dept AS t2')
                        -> where('t1.dept_id = t2.id')
                        -> select();

        //打印
        dump($result);
    }

    //join实现
    public function test44(){
        //实例化模型
        $model = M('Dept');
        //select t1.*,t2.name as deptname from sp_dept as t1 left join sp_dept as t2 on t1.pid = t2.id;
        //联表查询
        $result = $model
            -> field('t1.*,t2.name as deptname')
            -> alias('t1')
            -> join('left join sp_dept as t2 on t1.pid = t2.id')
            -> select();
        //打印
        dump($result);
    }
}


