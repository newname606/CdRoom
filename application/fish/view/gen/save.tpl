{extend name="Public:Basesave"/}
{block name="content"}
    <form action="" method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
        <?php foreach($fileds as $field):
            if($field['Field']=='id'||$field['Field']=='create_time') continue;
             if($field['Field']=='logo'):?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php $arr =  explode('@',$field['Comment']); echo $arr[0];?></label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" class="file" name="<?php echo $field['Field']; ?>">
            </div>
        </div>
        <?php  elseif($field['Field']=='textarea'): ?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php $arr =  explode('@',$field['Comment']); echo $arr[0];?></label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea  name="text" id="text">{$row['<?php echo $field["Field"]; ?>']?$row['<?php echo $field["Field"]; ?>']:''}</textarea>
            </div>
        </div>
        <input type="hidden" name="textarea" id="textarea" value="">
        <?php else: ?>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php $arr =  explode('@',$field['Comment']); echo $arr[0];?></label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{$row['<?php echo $field["Field"]; ?>']?$row['<?php echo $field["Field"]; ?>']:''}" name="<?php echo $field['Field']; ?>">
            </div>
        </div>
        <?php endif;?>
        <?php endForeach; ?>
        <input type="hidden" name="id" value="{$row['id'] ? $row['id'] : ''}">
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="button" onclick="obj_save()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
{/block}
