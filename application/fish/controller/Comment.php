<?php

namespace app\fish\controller;

class Comment extends Base{
    protected  $title = '楼盘评论管理';
    protected  $controller_name = "Comment";

    public function __index_data()
    {
        /*查询出所有楼盘名称*/
        $rows = model('Build')->field('id,bname,path')->paginate();
        $this->assign('rows',$rows);
    }

    /*评论详情页*/
    public function detail($id=0){
        $rows = model('Comment')->alias('a')
            ->field('a.id,a.content,a.create_time,a.heart,b.bname,c.uname')
            ->join('build b','a.roomid=b.id')
            ->join('UserInfo c','a.userid=c.id')
            ->where('a.roomid',$id)
            ->select();
        $this->assign('rows',$rows);
        return $this->fetch();
    }
}

