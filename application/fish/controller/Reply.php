<?php

namespace app\fish\controller;

class Reply extends Base
{
    protected $title = '评论回复管理';
    protected $controller_name = "Reply";

    public function __index_data()
    {
        $id = input('id');
        $rows = model('Reply')->where('commentid', $id)->paginate();
        $this->assign('rows', $rows);
    }
}


