<?php if (!defined('THINK_PATH')) exit();?>箭头形式：<br/><?php echo ($stu->id); ?><br/>
<?php echo ($stu->name); ?><br/>
<?php echo ($stu->sex); ?><br/><hr>

冒号形式：<br/><?php echo ($stu->id); ?><br/>
<?php echo ($stu->name); ?><br/>
<?php echo ($stu->sex); ?><br/><hr>

点形式：<?php echo ($stu["id"]); ?>