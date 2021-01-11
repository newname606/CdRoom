<?php

namespace app\fish\controller;

class Role extends Base{
    protected  $title = '角色';
    protected  $controller_name = "Role";

    public function index(){
        $rows = model($this->controller_name)->paginate();
        $count = model($this->controller_name)->count();
        $this->assign([
            'count'=>$count,
            'rows' => $rows,
        ]);
        $this->__index_data();
        return $this->fetch();
    }

    public function save($id=''){
        if (request()->isPost()){
            $data=input('post.');
            foreach($data as $k=>$v){
                if($k == 'id'){
                    continue;
                }else{
                    if($v == null || $v == ''){
                        return json(array('status'=>-2,'msg'=>'数据不能为空'));
                    }
                }
            }

            $data['menu_id'] = implode(',',$data['menu_id']);
            //添加时间
            $data['create_time']=time();
            //验证传过来的数据是否有密码字段没有就跳过
            if (input('post.password')!==null){
                if ($data['password']!==$data['password2']){
                    return json(array('status'=>-3,'msg'=>'两次密码不一致,请重新输入'));
                }else{unset($data['password2']);}
            }
            //添加和修改
            if (empty($id)){
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

    protected function __save_data(){
        $menus = db('menu')->field('id,name')->select();
        $id = input('id');
        if(!empty($id)){
            $authority = db('role')
                ->field('menu_id')
                ->where('id',$id)
                ->find();
//            dump($authority);die;
            $this->assign('authority',explode(',',$authority['menu_id']));
        }else{
            $this->assign('authority','');
        }
        $this->assign('menus',$menus);
    }
}

