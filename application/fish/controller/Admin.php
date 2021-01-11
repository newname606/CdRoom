<?php

namespace app\fish\controller;
use think\Controller;
use think\Request;

class Admin extends Controller {
    protected  $title = '用户';
    protected  $controller_name = "Admin";

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
            foreach($data as $k=>$v){
                if($k == 'id' || $k == 'pwd'){
                    continue;
                }else{
                    if($v == null || $v == ''){
                        return json(array('status'=>-2,'msg'=>'数据不能为空'));
                    }
                }
            }

            $request = Request::instance();
            //处理图片
            $file = $request->file('logo');
            if ($file) {
                $data['logo'] = image($file);
            }

            /*传入了密码*/
            if($data['pwd']) {
                $data['password'] = splicpwd($data['pwd']);
            }

            unset($data['pwd']);
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
        $row = db("Admin")->alias('a')
            ->field('a.*,b.name as r_name')->join('role b','a.role_id=b.id')
            ->paginate();
        $this->assign('rows',$row);
    }



    public function __save_data()
    {
        $role = db("role")->field('id,name')->select();
        $this->assign('role',$role);
    }

    public function uploadimage($path=false,$save=false){
        $file = request()->file('upload');
        $url = image($file);
        $url = str_replace("\\","/",$url);//把url的\换成/
        return json(['uploaded'=>true,'url'=>$url]);
    }
}

