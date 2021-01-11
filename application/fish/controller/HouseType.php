<?php

namespace app\fish\controller;

use think\Controller;
use think\Request;

class HouseType extends Controller {
    protected  $title = '楼盘户型管理';
    protected  $controller_name = "HouseType";
    public function index(){
        $rows = model($this->controller_name)->paginate();
        $count = model($this->controller_name)->count();
        $this->assign([
            'count' => $count,
            'rows'  => $rows,
        ]);
        $this->__index_data();
        return $this->fetch();
    }

    public function save($id=''){
        if (request()->isPost()){
            $data=input('post.');
//            dump($data);die;
            foreach($data as $k=>$v){
                if($k == 'id'){
                    continue;
                }else{
                    if($v == null || $v == ''){
                        return json(array('status'=>-2,'msg'=>'数据不能为空'));
                    }
                }
            }
            if(isset($data['textarea'])){
                $data['text'] = $data['textarea'];
                unset($data['textarea']);
            }

            $request = Request::instance();

            //处理图片
            $file = $request->file('logo');
            if ($file) {
                $data['logo'] = image($file);
            }else{
                if($id){
                    $res = db($this->controller_name)->find($id);
                    $data['logo']= $res['logo'];
                }
            }

            //添加和修改
            if (empty($id)){
                //添加时间
                $data['create_time']=time();
                unset($data['id']);
                $result = model($this->controller_name)->allowField(true)->insert($data);
            }else{
                $result = model($this->controller_name)->update($data);
            }
            if($result){
                return json(array('status'=>1,'msg'=>'编辑成功'));
            }else{
                return json(array('status'=>-1,'msg'=>'编辑失败'));
            }
        }
        $this->__save_data();
        if(!empty($id)) {
            $row = model($this->controller_name)->find($id);
            $this->assign('row', $row);
        }
        return $this->fetch();
    }

    /*删除单条数据*/
    public function del($id){
        $result =model($this->controller_name)->where('id',$id)->delete();
        if ($result) {
            return json(array('status'=>1,'msg'=>'删除成功'));//删除成功
        }else{
            return json(array('status'=>0,'msg'=>'删除失败'));//删除失败
        }
    }

    /*删除多条数据*/
    public  function delall($id){
        $res = model($this->controller_name)->where('id','in',$id)->delete();
        if ($res){
            return 1;
        }else{
            return -1;
        }
    }

    public function __index_data()
    {
        /*查询出所有楼盘名称*/
        $rows = model('Build')->field('id,bname,path')->paginate();
        $this->assign('rows',$rows);
    }

    /*评论详情页*/
    public function detail($id){
        $rows = db("HouseType")->alias('a')
            ->field('a.*,b.bname')
            ->join('build b','a.roomid=b.id')
            ->order('b.bname')
            ->where('a.roomid',$id)
            ->paginate();
        $count = db('HouseType')->count();
        $this->assign([
            'rows'=>$rows,
            'count'=>$count
        ]);
        return $this->fetch();
    }

    public function __save_data()
    {
        /*查询出所有楼盘名称*/
        $builds = db("build")->field('id,bname')->select();

        $this->assign('builds',$builds);
    }
}

