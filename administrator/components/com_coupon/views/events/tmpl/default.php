<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	if($this->lists['order']=='a.ordering' && $this->lists['order_Dir']=='desc'){ $order= 1;}
	JToolBarHelper::title(JText::_('EVENT MANAGER'), 'frontpage' );
	JToolBarHelper::customX( 'update', 'upload.png', 'upload_f2.png', JText::_( 'UPDATE' ), false );
	JToolBarHelper::customX( 'copyEvent', 'copy.png', 'copy_f2.png', JText::_( 'copy' ), false );	
	JToolBarHelper::deleteList();
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();
	JToolBarHelper::preferences('com_coupon', '500');
?>
<form action="index.php" method="post" name="adminForm">
	<table width="100%" cellpadding="4">
		<tr>
        	<!--
			<td width="50%">
				<?php echo JText::_( 'Event status' ); ?>:
				<?php echo $this->lists['status']; ?>
			</td>
            -->			
            <td width="1%" nowrap="nowrap" align="right">
				<?php echo JText::_( 'Category' ); ?>:
				<?php echo $this->lists['category']; ?>
			</td>				
		</tr>
	</table>
	<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="1%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="1%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				</th>				
				<th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('TITLE'), 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('Category'), 'c.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('price'), 'a.price', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('Ordering'), 'a.ordering', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>	
                <th class="title">
					<?php echo JHTML::_('grid.sort', 'Акция дня', 'a.day', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('Published'), 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>							
				<th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'a.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="11">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			if($this->lists['order']=='a.ordering DESC, a.dateStart') $order=1;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row 	=& $this->items[$i];
				$link 	= 'index.php?option=com_coupon&amp;controller=event&amp;view=event&amp;task=edit&amp;cid[]='. $row->id. '';
				$published 	= JHTML::_('grid.published', $row, $i);
				if($this->pagination->limitstart || $i){
					$up = 'index.php?option=com_coupon&amp;controller=event&amp;task=up&amp;id='.$row->id.'&amp;catid='.JRequest::getVar( 'catid', '', '', 'int' );
				}
				$down = 'index.php?option=com_coupon&amp;controller=event&amp;task=down&amp;id='.$row->id.'&amp;catid='.JRequest::getVar( 'catid', '', '', 'int' );
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo $row->title; ?></a>
				</td>
                <td align="center" nowrap="nowrap">
					<?php echo $row->category; ?>
				</td>
                <td align="center">
					<?php echo $row->free ? 'бесплатно' : $row->price; ?>
				</td>
                <td align="center">
                	<?php if($order){?>
						<?php if($up){ ?>
                        <span><a href="<?php echo $up;?>" title="Вверх">   <img src="images/uparrow.png" width="16" height="16" border="0" alt="Вверх" /></a></span>
                        <?php } ?>
                        <span><a href="<?php echo $down;?>" title="Вниз">  <img src="images/downarrow.png" width="16" height="16" border="0" alt="Вниз" /></a></span>
                    <?php }else{ ?>
                    	<?php if($up){ ?>
                    	<span><img src="images/uparrow0.png" width="16" height="16" border="0" alt="Вверх" /></span>
                        <?php } ?>
						<span><img src="images/downarrow0.png" width="16" height="16" border="0" alt="Вниз" /></span>
                    <?php } ?>
				</td>		
                <td align="center">
					<?php if($row->day){ ?>
                        <img src="images/tick.png" border="0" alt="Опубликовано"/>
                    <?php } ?>
				</td>	
                <td align="center">
					<?php echo $published; ?>
				</td>																								
				<td>
					<?php echo $row->id; ?>
				</td>
			</tr>
			
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
	
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="controller" value="event" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>


