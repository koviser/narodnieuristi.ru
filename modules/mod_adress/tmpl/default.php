<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="how-to-find-us">
	<section>
		<h2>Адреса региональных филиалов</h2>
        <ul>
        <?php for($i=0;$i<count($rows);$i++){?>
			<li>
				<div class="map">
					<img height="105" width="134" src ="http://static-maps.yandex.ru/1.x/?size=134,105&amp;z=11&amp;l=map&amp;pt=<?php echo $rows[$i]->longitude; ?>,<?php echo $rows[$i]->latitude; ?>,pmdom&amp;key=AE5rJ1IBAAAAEef8OAIAScTGQad7MtbKpF-0bnyZ4y_30xkAAAAAAAAAAAB5NJvvuYad3kuH_RrSYTdaZc-Qzw==" />
					<a href="index.php?option=com_doc&view=map&id=<?php echo $rows[$i]->id;?>&tmpl=component" class="fancybox-maps"><span>Увеличить</span></a>
				</div>
				<div class="meta">
					<p class="name"><?php echo $rows[$i]->front_title;?></p>
					<p class="address"><?php echo $rows[$i]->adress;?></p>
					<div class="work-time">
						<span>Время работы:</span>
						<p><?php echo $rows[$i]->time;?></p>
					</div>
					<div class="contacts">
						<span>Телефон:</span>
						<p><?php echo $rows[$i]->phone;?></p>
					</div>
                </div>
			</li>
		<?php } ?>
		</ul>
	</section>
</div>