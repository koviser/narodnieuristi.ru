<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	JToolBarHelper::title(JText::_('GIFTCARD MANAGER'), 'frontpage' );
	JToolBarHelper::deleteList();
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();
?>
<form action="index.php" method="post" name="adminForm">
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
                <th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort', JText::_('price card'), 'a.price', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>	
                <th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort', JText::_('Number purchased'), 'a.count', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>	
                <th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort', JText::_('Published'), 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>					
				<th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'a.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="13">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$age=array();
				$row 	=& $this->items[$i];
				$link 	= 'index.php?option=com_coupon&amp;controller=giftcard&amp;view=giftcard&amp;task=edit&amp;cid[]='. $row->id. '';
				$published 	= JHTML::_('grid.published', $row, $i);
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
                <td align="center">
					<?php echo $row->price; ?>
				</td>	
                <td align="center">
					<?php echo $row->count; ?>
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
	<input type="hidden" name="controller" value="giftcard" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>


