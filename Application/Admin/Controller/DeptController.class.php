<?php
namespace Admin\Controller;
//use Admin\Model\DeptModel;
use Think\Controller;

class DeptController extends Controller{
    //展示实例化的结果
    public function shilihua(){
        //普通实例化方法
//        $model = new DeptModel();
        //实例化自定义模型 D
//        $model = D('Dept');//其实例化结果和使用普通new方法是一样的
//        $model = D(); //实例化父类模型

        //实例化父类
        $model = M('Dept');//关联数据表
        $model = M();   //实例化父类模型，不关联数据表
        dump($model);
    }

    //add方法使用
    public function tianjia(){
        //实例化模型
        $model = M('Dept'); //直接使用基本的增删改查可以使用父类模型
        //声明数组（关联数组）
//        $data = array(
//            'name'   => '财务部',
//            'pid'    => '0',
//            'sort'   => '2',
//            'remark' => '这是财务部门',
//        );
//        $result = $model -> add($data); //增加操作

        //批量添加
        $data = array(
            array(
                'pid'    => '0',
                'name'   => '公关部',
                'sort'   => '3',
                'remark' => '公共关系维护'
            ),
            array(
                'pid'    => '0',
                'name'   => '总裁办',
                'sort'   => '4',
                'remark' => '权力最高的部门',
            )
        );
        //批量增加
        $result = $model -> addAll($data);
        dump($result);
    }

    //save方法的使用
    public function xiugai(){
        //实例化模型
        $model = M('Dept');
        //修改操作
        $data = array(
            'id' => '2',
            'sort' => '22',
            'remark' => '今天发工资',
        );
        $result = $model -> save($data);
        //打印
        dump($result);
    }

    //查询
    public function chaxun(){
        //实例化模型
        $model = M('Dept');
        //select部门 （返回的是二维数组）
        $data = $model -> select();//查询全部
        $data = $model -> select(10); //指定id
        $data = $model -> select('1,2');//指定id集合

        //find部分 （返回的是一维数组）
        $data = $model -> find();//limit 1
        $data = $model -> find(1);//指定id
        //打印
        dump($data);
    }

    //删除操作
    public function shanchu(){
        //实例化模型
        $model = M('Dept');
        //删除操作
//        $result = $model -> delete();//false
//        $result = $model -> delete(1);//删除指定id
        $result = $model -> delete('1,7');
        //打印
        dump($result);
    }

    //add方法
    public function add(){
        //判断请求类型(判断是否是post请求，如果是，则处理表单的提交，如果不是则展示模板)
        if(IS_POST){ //判断请求是否是post （如果请求是post,则IS_POST的值是true 否则是false）
            //处理表单提交
//            $post = I('post.');
            //写入数据
            $model = D('Dept');
            //数据对象创建
            $data = $model -> create(); //不传递参数则接收post数据
            if(!$data){ //成功就返回数组 失败返回false
                //提示用户验证失败
//                dump($model -> getError());
//                die();
                $this -> error($model -> getError());//后面不用给参数了，因为默认跳转上一页
                exit;//虽然php在上面已经跳转了 但是php会自己执行下面的代码 所以这里要退出
            }
            dump($data);die();
            $result = $model -> add();
            //判断返回值
            if($result){
                //成功
                $this->success('添加成功',U('showList'),3);
            }else{
                //失败
                $this->error('添加失败');
            }
        }else{
            //查询出顶级部门
            $model = M('Dept');
            $data = $model -> where('pid = 0') -> select();
            //展示数据
            $this -> assign('data',$data);
            //展示模板
            $this -> display();
        }
    }

    //showList
    public function showList(){ //不要使用list方法，list 和 read是关键词
        //模型实例化
        $model = M('Dept');
        //查询
        $data = $model -> order('sort ASC') -> select();
        foreach ($data as $key => $value){
            if($value['pid'] > 0){ //pid必须不是0
                //查询pid对应的部门信息
                $pInfo = $model -> find($value['pid']);
                //只需要保留其中的name
                $data[$key]['pdeptname']  = $pInfo['name'];
            }
        }
        //使用load方法载入文件
        load('@/tree');
        $data = getTree($data);
        //传递模板
        $this -> assign('data',$data); //因为是select查询 所以是二维数组的结果
        //展示模板
        $this -> display();
    }

    //edit
    public function edit(){
        if(IS_POST){ //处理post请求
            //接受表单提交过来的数据
            $post = I('post.');
            //实例化模型类
            $model = M('Dept');
            //保存操作
            $result = $model -> save($post);
            //判断结果成功与否（返回影响行数）
            if($result !== false){ //如果查询返回非false值
                //修改成功
                if($result > 0){ //如果查询影响了多于0行
                    $this->success('修改成功',U('showList'),3);
                }else{ //如果查询影响了0行 （这是修改页面没有任何改动 直接按提交 数据库会返回0）
                    $this->success('操作成功，但未做任何修改',U('showList'),3);
                }
            }else{
                //修改失败 （如果什么都没改动 直接按提交 页面会提示修改失败）
                $this->error('修改失败');//不传递url参数，就是返回上一页
            }
        }else{
            $id = I('get.id');
            //模型实例化
            $model = M('Dept');
            //查询
            $data = $model -> find($id);
            //查询全部的部门信息，给下拉列表使用
            $datas = $model -> where("id != $id") -> select();
            //传递给模板
            $this -> assign('data',$data);
            $this -> assign('datas',$datas);
            //展示模板
            $this->display();
        }
    }

    //del
    public function del(){
        //接收参数
        $id = I('get.id');
        //模型实例化
        $model = M('Dept');
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
}