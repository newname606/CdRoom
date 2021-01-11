<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"E:\CdRoom\generate\public/../application/fish\view\build\save.html";i:1610353147;s:71:"E:\CdRoom\generate\public/../application/fish\view\Public\Basesave.html";i:1610347106;}*/ ?>
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
        <label class="form-label col-xs-4 col-sm-3">楼盘名称</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" value="<?php echo !empty($row['bname'])?$row['bname']:''; ?>" name="bname">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">楼盘地址</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如四川省成都市金牛区" class="input-text" value="<?php echo !empty($row['path'])?$row['path']:''; ?>" name="path">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">参考价格</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" placeholder="17000-19000元/㎡" value="<?php echo !empty($row['price'])?$row['price']:''; ?>" name="price">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">占地面积</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" placeholder="50000平方米" value="<?php echo !empty($row['area_covered'])?$row['area_covered']:''; ?>"
                   name="area_covered">
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">楼盘面积</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" placeholder="15000平方米" value="<?php echo !empty($row['area_build'])?$row['area_build']:''; ?>" name="area_build">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">面积</label>
        <div class="formControls col-xs-8 col-sm-9">
            <select class="btn btn-primary radius" name="areaid" id="areaid">
                <option value="">--请选择--</option>
                <?php if(is_array($areas) || $areas instanceof \think\Collection || $areas instanceof \think\Paginator): $i = 0; $__LIST__ = $areas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$area): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $area['id']; ?>"
                <?php if(isset($row)){ if($area['id']==$row['areaid']){ ?> selected="selected" <?php }} ?> ><?php echo $area['area']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">单价</label>
        <div class="formControls col-xs-8 col-sm-9">
            <select class="btn btn-primary radius" name="unitid" id="unitid">
                <option value="">--请选择--</option>
                <?php if(is_array($units) || $units instanceof \think\Collection || $units instanceof \think\Paginator): $i = 0; $__LIST__ = $units;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$unit): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $unit['id']; ?>"
                <?php if(isset($row)){ if($unit['id']==$row['unitid']){ ?> selected="selected" <?php }} ?> ><?php echo $unit['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">总价</label>
        <div class="formControls col-xs-8 col-sm-9">
            <select class="btn btn-primary radius" name="totalid" id="totalid">
                <option value="">--请选择--</option>
                <?php if(is_array($totals) || $totals instanceof \think\Collection || $totals instanceof \think\Paginator): $i = 0; $__LIST__ = $totals;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$total): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $total['id']; ?>"
                <?php if(isset($row)){ if($total['id']==$row['totalid']){ ?> selected="selected" <?php }} ?> ><?php echo $total['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>



    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">标签</label>
        <div class="formControls col-xs-8 col-sm-9">
            <label>
                <?php if(is_array($labels) || $labels instanceof \think\Collection || $labels instanceof \think\Paginator): $i = 0; $__LIST__ = $labels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$label): $mod = ($i % 2 );++$i;?>
                <label>
                    <?php if($authlabel != null): ?>
                    <input type="checkbox" <?php if(in_array($label['id'],$authlabel)){ echo 'checked="checked"'; }   ?>
                    name="labelid[]" value="<?php echo $label['id']; ?>"><?php echo $label['name']; else: ?>
                    <input type="checkbox" name="labelid[]" value="<?php echo $label['id']; ?>"><?php echo $label['name']; endif; ?>
                </label>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </label>
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">装修</label>
        <div class="formControls col-xs-8 col-sm-9">
            <select class="btn btn-primary radius" name="zgxiuid" id="zgxiuid">
                <option value="">--请选择--</option>
                <?php if(is_array($zgxius) || $zgxius instanceof \think\Collection || $zgxius instanceof \think\Paginator): $i = 0; $__LIST__ = $zgxius;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$zgxiu): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $zgxiu['id']; ?>"
                <?php if(isset($row)){ if($zgxiu['id']==$row['zgxiuid']){ ?> selected="selected" <?php }} ?> ><?php echo $zgxiu['name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>

    <!--<div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">户型</label>
        <div class="formControls col-xs-8 col-sm-9">
            <select class="btn btn-primary radius" name="typeid" id="typeid">
                <option value="">&#45;&#45;请选择&#45;&#45;</option>
                <?php if(is_array($types) || $types instanceof \think\Collection || $types instanceof \think\Paginator): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $type['id']; ?>"
                <?php if(isset($row)){ if($type['id']==$row['typeid']){ ?> selected="selected" <?php }} ?> ><?php echo $type['type']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>-->
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">户型</label>
        <div class="formControls col-xs-8 col-sm-9">
            <label>
                <?php if(is_array($types) || $types instanceof \think\Collection || $types instanceof \think\Paginator): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?>
                <label>
                    <?php if($authtype != null): ?>
                    <input type="checkbox" <?php if(in_array($type['id'],$authtype)){ echo 'checked="checked"'; }   ?>
                    name="typeid[]" value="<?php echo $type['id']; ?>"><?php echo $type['type']; ?>&nbsp;&nbsp;
                    <?php else: ?>
                    <input type="checkbox" name="typeid[]" value="<?php echo $type['id']; ?>"><?php echo $type['type']; endif; ?>
                </label>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </label>
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">分类</label>
        <div class="formControls col-xs-8 col-sm-9">
            <label>
                <?php if(is_array($sorts) || $sorts instanceof \think\Collection || $sorts instanceof \think\Paginator): $i = 0; $__LIST__ = $sorts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sort): $mod = ($i % 2 );++$i;?>
                <label>
                    <?php if($authsort != null): ?>
                    <input type="checkbox" <?php if(in_array($sort['id'],$authsort)){ echo 'checked="checked"'; }   ?>
                    name="sortid[]" value="<?php echo $sort['id']; ?>"><?php echo $sort['name']; ?>&nbsp;&nbsp;
                    <?php else: ?>
                    <input type="checkbox" name="sortid[]" value="<?php echo $sort['id']; ?>"><?php echo $sort['name']; endif; ?>
                </label>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </label>
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">预售证号</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如51010820205238" class="input-text" value="<?php echo !empty($row['sale_num'])?$row['sale_num']:''; ?>" name="sale_num">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">物业类型</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如洋房,小高层" class="input-text" value="<?php echo !empty($row['wy_type'])?$row['wy_type']:''; ?>" name="wy_type">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">产权年限</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如住宅70年" class="input-text" value="<?php echo !empty($row['cq_year'])?$row['cq_year']:''; ?>" name="cq_year">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">环线位置</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如二环-三环" class="input-text" value="<?php echo !empty($row['loop_line'])?$row['loop_line']:''; ?>" name="loop_line">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">开发商</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如中车科技园有限公司" class="input-text" value="<?php echo !empty($row['developer'])?$row['developer']:''; ?>" name="developer">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">容积率</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如2.0(二期)" class="input-text" value="<?php echo !empty($row['plot_ratio'])?$row['plot_ratio']:''; ?>" name="plot_ratio">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">绿化率</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如30%(二期绿化率)" class="input-text" value="<?php echo !empty($row['green_rate'])?$row['green_rate']:''; ?>" name="green_rate">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">绿地率</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如30%(二期绿化率)" class="input-text" value="<?php echo !empty($row['green_space_rate'])?$row['green_space_rate']:''; ?>"
                   name="green_space_rate">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">停车位</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如1147(二期)" class="input-text" value="<?php echo !empty($row['park_space'])?$row['park_space']:''; ?>" name="park_space">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">楼栋总数</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="19栋(二期)" class="input-text" value="<?php echo !empty($row['build_num'])?$row['build_num']:''; ?>" name="build_num">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">总户数</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如604户" class="input-text" value="<?php echo !empty($row['total_num'])?$row['total_num']:''; ?>" name="total_num">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">物业费</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如二期:3.5/㎡" class="input-text" value="<?php echo !empty($row['wy_fee'])?$row['wy_fee']:''; ?>" name="wy_fee">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">楼层状况</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如7F,9F,10F(二期),1梯两户" class="input-text" value="<?php echo !empty($row['build_condition'])?$row['build_condition']:''; ?>"
                   name="build_condition">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">交房时间</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" placeholder="如2022年6月30日" class="input-text" value="<?php echo !empty($row['trade_time'])?$row['trade_time']:''; ?>" name="trade_time">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">楼盘图片</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input multiple type="file" class="file" name="logos[]">
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3">楼盘总平图</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="file" class="file" name="build_logo">
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