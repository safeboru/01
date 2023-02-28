<?php
//声明命名空间
namespace Admin\Controller;
//引入父类
use Think\Controller;
//声明类继承父类
class UserController extends Controller{

    //add方法
    public function add(){
        if(IS_POST){
            //处理表单提交
            $model = M('User');
            //创建数据对象
            $data = $model -> create();
            //添加时间字段
            $data['addtime'] = time();
            //保存数据表
            $result = $model -> add($data);//返回主键id
            //判断是否保存成功 (不是0的都是真)
            if($result){
                //成功
                $this -> success('添加成功！',U('showList'),3);
            }else{
                //失败
                $this -> error('添加失败！'); //默认就是返回上一页
            }
        }else{
            //查询部门信息
            $data = M('Dept') -> field('id,name') -> select();
            //传递给模板
            $this -> assign('data',$data);
            //展示模板
            $this -> display();
        }
    }

    //showList
    public function showList(){
        $model  = M('User');                            //实例化User对象
        $count = $model -> count();                     //查询总记录数
        $page  = new \Think\Page($count,2);     //实例化分页类 传入总记录数和每页显示的记录数（5）

        $page -> rollPage = 2;
        $page -> lastSuffix = false;                    //由于分页类中 lastSuffix 属性 定义最后一页显示总页数 所以将其改为 false
        $page -> setConfig('prev','上一页'); //可选步骤 定义提示文字
        $page -> setConfig('next','下一页');
        $page -> setConfig('last','末页');
        $page -> setConfig('first','首页'); //设置首页和末页的时候需要注意，如果总的页码数小于分页类中 rollPage 属性，则不会显示首页和末页的按钮 这个时候需要修改 rollPage 的值

        $show  = $page -> show();                      //分页显示输出

        //进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $data = $model -> limit($page->firstRow.','.$page->listRows) -> select();

        $this -> assign('data',$data);                 //赋值数据集
        $this->assign('show',$show);                   // 赋值分页输出

        $this -> display();                            //展示模板
    }

    //edit
    public function edit(){
        if(IS_POST){ //处理post请求
            //接受表单提交过来的数据
            $post = I('post.');
            //实例化模型类
            $model = M('User');
            //保存操作
            $result = $model -> save($post);
            //判断结果成功与否（返回影响行数）
            if($result !== false){
                //修改成功
                if($result > 0){ //如果查询影响了多于0行
                    $this -> success('修改成功',U('showList'),3);
                }else{ //如果查询影响了0行（这是修改页面没有任何改动，直接提交 数据库会返回0）
                    $this -> success('操作成功，但未做任何修改',U('showList'),3);
                }
            }else{
                //修改失败 （如果什么都没改动 直接提交 页面会提示修改失败）
                $this -> error('修改失败'); //不传递url参数，就是返回上一页
            }
        }else{
            $id = I('get.id');
            //实例化模型
            $model = M('User');
            //查询
            $data = $model -> find($id);

            //实例化部门模型
            $model = M('Dept');
            //查询用户所属部门的名字
            $dept = $model -> field('id,name') -> find($data['dept_id']);
            $data['deptname'] = $dept['name'];

            //查询全部部门
            $depts = $model -> select();

            //传递给模板
            $this -> assign('data',$data);
            $this -> assign('depts',$depts);
            //展示模板
            $this -> display();
        }
    }

    //del
    public function del(){
        //接收参数
        $id = I('get.id');
        //模型实例化
        $model = M('User');
        //删除
        $result = $model -> delete($id);
        //判断结果
        if($result){
            //删除成功
            $this -> success('删除成功！');//跳转到列表页 因为列表页是上一页所以不用写url
        }else{
            //删除失败
            $this -> error('删除失败！');
        }
    }

    //charts方法
    public function charts(){
        //select t2.name as deptname,count(*) as count
        //from sp_user as t1,sp_dept as t2
        //where t1.dept_id = t2.id
        //group by deptname;

        //模型实例化
        $model = M();
        //连贯操作
        $data = $model
            -> field('t2.name as deptname,count(*) as count')
            -> table('sp_user as t1,sp_dept as t2')
            -> where('t1.dept_id = t2.id')
            -> group('deptname')
            -> select();

        //如果当前使用的php版本是5.6之后的版本，则可以直接将data二维数组assign,不需要任何处理；但是当前的php是5.3，所以需要进行字符串拼接

        $str = '[';

        //循环遍历字符串
        foreach($data as $key => $value){
            $str .= "['" . $value['deptname'] . "'," . $value['count'] . "],";
        }

        //去除最后的逗号
        $str = rtrim($str,',') . ']';
        //[['人事部',1],['程序部',3],['管理部',1],['财务部',1],['运营部',1]]

        $this -> assign('str',$str);

        //展示模板
        $this -> display();
    }

}

//select t2.name as deptname,count(id) as count
//from sp_user as t1
//left join sp_dept as t2
//order by t1.dept_id ASC
//group by t1.dept_id
//on t1.dept_id = t2.id




