<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"E:\CdRoom\generate\public/../application/fish\view\reply\index.html";i:1609827179;s:72:"E:\CdRoom\generate\public/../application/fish\view\Public\Baseindex.html";i:1609729343;}*/ ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="__ADMIN__/lib/html5shiv.js"></script>
    <script type="text/javascript" src="__ADMIN__/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="__ADMIN__/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="__ADMIN__/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="__ADMIN__/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="__ADMIN__/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="__ADMIN__/static/h-ui.admin/css/style.css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="__ADMIN__/lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
</head>
<body>
<div class="page-container">
    <div class="mt-20">
        
<div class="cl pd-5 bg-1 bk-gray mt-20">
    <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
    <span class="r">共有数据：<strong><?php echo $count; ?></strong> 条</span></div>
<table class="table table-border table-bordered table-hover table-bg table-sort">
    <thead>
    <tr>
        <th width="25"><input type="checkbox"></th>
        <th>编号</th>
        <th>用户名称</th>
        <th>回复名称(为空默认一级)</th>
        <th>内容</th>
        <th>时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <?php if(is_array($rows) || $rows instanceof \think\Collection || $rows instanceof \think\Paginator): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?>
    <tbody>
    <tr>
        <td><input type="checkbox" value="<?php echo $row['id']; ?>" name="id"></td>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['replyname']; ?></td>
        <td><?php echo $row['content']; ?></td>
        <td><?php echo $row['create_time']; ?></td>
        <td class="td-manage">
            <a title="删除" href="javascript:;" onclick="obj_del(this,<?php echo $row['id']; ?>)" class="ml-5" style="text-decoration:none">
            <i class="Hui-iconfont">&#xe6e2;</i></a>
        </td>
    </tr>
    </tbody>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</table>

        <?php echo $rows->render(); ?>
    </div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="__ADMIN__/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__ADMIN__/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="__ADMIN__/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="__ADMIN__/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->
<script type="text/javascript">
    /*批量删除*/
    function datadel() {
        /*获取选中的id*/
        var obj = document.getElementsByName("id");

        var check_val = [];
        for (var i = 0; obj.length > i; i++) {
            if (obj[i].checked) {
                check_val.push(obj[i].value);
            }
        }

        $.ajax({
            type: 'get',
            url: "<?php echo url('delall'); ?>",
            data: {id: check_val},
            dataType: "json",
            success: function (data) {
                if (data == 1) {
                    location.href = "<?php echo url('index'); ?>";
                    /*跳转修改页面*/
                } else {
                    layer.msg('删除失败!', {icon: 5, time: 1000});
                    return false;
                }
            }
        })
    }

    /*删除*/
    function obj_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $.ajax({
                type: 'POST',
                url: "<?php echo url('del'); ?>",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    if (data.status == 1) {
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!', {icon: 1, time: 1000});
                    }
                    else {
                        layer.msg('删除失败!', {icon: 5, time: 1000});
                    }
                },
                error: function (data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*管理员-停用*/
    function admin_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type : "post",
                url  : "<?php echo url('statestop'); ?>",
                data : {id:id},
                dataType: "json",
                success: function (data) {
                    if(data == 1){

                        $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                        $(obj).remove();
                        layer.msg('已停用!',{icon: 6,time:1000});
                    }else{
                        layer.msg('请稍后再试!', {icon: 5,time:1000});
                    }
                }
            });

        });
    }

    /*管理员-启用*/
    function admin_start(obj,id){
        layer.confirm('确认要启用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type : "post",
                url  : "<?php echo url('statestart'); ?>",
                data : {id:id},
                dataType: "json",
                success: function (data) {
                    if(data == 1){
                        $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                        $(obj).remove();
                        layer.msg('已启用!', {icon: 6,time:1000});
                    }else{
                        layer.msg('请稍后再试!', {icon: 5,time:1000});
                    }
                }
            });


        });
    }
</script>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="__ADMIN__/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="__ADMIN__/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="__ADMIN__/lib/laypage/1.2/laypage.js"></script>
</body>
</html>