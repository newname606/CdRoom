<?php

namespace app\fish\controller;

use think\Controller;
use think\Request;

class Dongtai extends Controller {
    protected  $title = '楼盘动态管理';
    protected  $controller_name = "Dongtai";

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
            }

            /*多图拼接字符串*/
            $logos = $request->file('logos');
            if($logos){
                $data['logos'] = images($file);
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


    /*楼盘动态*/
    public function detail($id){

        $row = db('Dongtai')->alias('a')
            ->field('a.*,b.bname b_name,c.name l_name')
            ->join('Build b','a.roomid=b.id')
            ->join('Label c','a.labelid=c.id')
            ->where('a.roomid',$id)

            ->paginate();

        $count = db('Dongtai')->count();
        $this->assign([
            'rows'=>$row,
            'count'=>$count
        ]);
        return $this->fetch();
    }


    /*富文本查看*/
    public function textarea($id=''){
        $data = db('Dongtai')->field('id,text')->find($id);
//        dump($data);die;
        $this->assign('data',$data);
        return $this->fetch();

    }

    public function __save_data()
    {
        $Label = db('Label')->select();
        $build = db('Build')->select();
        $this->assign('builds',$build);
        $this->assign('label',$Label);
    }


    public function uploadimage($path=false,$save=false){
        $file = request()->file('upload');
        $url = image($file);
        $url = str_replace("\\","/",$url);//把url的\换成/
        return json(['uploaded'=>true,'url'=>$url]);
    }
}

