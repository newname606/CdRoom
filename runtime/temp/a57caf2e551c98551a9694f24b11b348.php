<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"E:\CdRoom\generate\public/../application/fish\view\house_type\save.html";i:1609731885;s:71:"E:\CdRoom\generate\public/../application/fish\view\Public\Basesave.html";i:1610347106;}*/ ?>
<!--_meta 作为公共模版分离出去-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
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
    <link rel="Bookmark" href="__ADMIN__/favicon.ico">
    <link rel="Shortcut Icon" href="__ADMIN__/favicon.ico"/>
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
    <!--/meta 作为公共模版分离出去-->
</head>
<body>
<article class="page-container">
    
<form action="" method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">楼盘</label>
        <div class="formControls col-xs-8 col-sm-9">
            <select class="btn btn-primary radius" name="roomid" id="roomid">
                <option value="">--请选择--</option>
                <?php if(is_array($builds) || $builds instanceof \think\Collection || $builds instanceof \think\Paginator): $i = 0; $__LIST__ = $builds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$build): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $build['id']; ?>"
                <?php if(isset($row)){ if($build['id']==$row['roomid']){ ?> selected="selected" <?php }} ?> ><?php echo $build['bname']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">户型名称</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" placeholder="请输入户型名称,如两室一厅,一室一厅" value="<?php echo !empty($row['title'])?$row['title']:''; ?>" name="title">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">户型图</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="file" class="file" name="logo"><span style="color: red;">不选择默认不修改*</span>
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">户型分类</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" placeholder="请输入户型分类,如A1,A2" value="<?php echo !empty($row['type'])?$row['type']:''; ?>" name="type">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">户型面积</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" placeholder="请输入户型面积,如70㎡" value="<?php echo !empty($row['area'])?$row['area']:''; ?>" name="area">
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo !empty($row['id'])?$row['id'] : ''; ?>">
    <div class="row cl">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
            <input class="btn btn-primary radius" type="button" onclick="obj_save()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        </div>
    </div>
</form>

</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="__ADMIN__/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__ADMIN__/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="__ADMIN__/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="__ADMIN__/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<script type="text/javascript" src="__ADMIN__/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="__ADMIN__/ckeditor/ckfinder/ckfinder.js"></script>
<script type="text/javascript">

    CKEDITOR.replace('text', { //这里的 mycontent就是上面我们设置的textarea或者input元素的id
            filebrowserUploadUrl: '/fish.php/admin/uploadimage?command=QuickUpload&type=Files&responseType=json',
            width: 900,//设置默认宽度为900px
            height: 300  //设置默认高度是300px，这个高度是不包含顶部菜单的高度
        }
    );

    /*修改*/
    function obj_save() {

        var text = document.getElementsByName("text");

        if (text.length != 0) {
            var text = CKEDITOR.instances.text.getData();/*获取富文本*/
            if (text != "" || text != null) {
                $("#textarea").attr("value", text);/*富文本渲染值*/
            }
        }

        var form = document.getElementById("form-member-add");
        var formdata = new FormData(form);
        $.ajax({
            type: 'POST',
            url: "<?php echo url('save'); ?>",
            processData: false,  // 不要处理发送的数据
            contentType: false,   // 不要设置Content-Type请求头
            data: formdata,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.status == -2) {
                    layer.msg(data.msg, {icon: 1, time: 1000});/*数据不能为空*/
                    return false;
                } else if (data.status == 1) {
                    layer.msg(data.msg, {icon: 1, time: 1000});/*成功*/
                    setTimeout(function () {
                        location.href = "<?php echo url('index'); ?>";
                    }, 1000);
                } else if (data.status == -1) {
                    layer.msg(data.msg, {icon: 5, time: 1000});/*失败*/
                    return false;
                } else {
                    layer.msg(data.msg, {icon: 1, time: 1000});
                    return false;
                }
            },
            error: function (data) {
                console.log(data.msg);
            },
        });
    }


</script>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="__ADMIN__/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="__ADMIN__/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="__ADMIN__/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="__ADMIN__/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>