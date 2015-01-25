<?php defined('_JEXEC') or die('Restricted access'); ?>
<nav class="menu">
	<ul>
    <?php 
        for($i=0;$i<count($rows);$i++){
    ?>
    	<li><a href="<?php echo JRoute::_('index.php?option=com_coupon&view=now&catid='.$rows[$i]->id);?>" class="icons-menu ico-m<?php echo ($i+1);?>"><span><?php echo $rows[$i]->title;?></span></a></li>
    <? } ?>
    </ul>
</nav>