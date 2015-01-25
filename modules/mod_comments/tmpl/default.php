<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="reviews">
	<h2>Отзывы наших клиентов</h2>
	<section>
        <?php for($i=0;$i<count($rows);$i++){?>
		<figure>
			<a href=""><img src="<?php echo $rows[$i]->image;?>" alt="" /></a>
			<figcaption>
				<h2><?php echo $rows[$i]->name;?></h2>
				<?php echo $rows[$i]->text;?>
			</figcaption>
		</figure>
        <?php } ?>
	</section>
</div>