<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="slider">
	<section>
    	<p>Примеры дел</p>
		<a href="" class="left"></a>
		<a href="" class="right"></a>
		<ul>
        <?php for($i=0;$i<count($rows);$i++){?>
			<li>
				<div class="meta">
					<h1><?php echo $rows[$i]->title;?></h1>
					<?php echo $rows[$i]->full_text;?>
				</div>
				<div class="img-box">
					<img src="<?php echo $rows[$i]->image;?>" alt="" />
				</div>
			</li>
        <?php } ?>
		</ul>
	</section>
</div>