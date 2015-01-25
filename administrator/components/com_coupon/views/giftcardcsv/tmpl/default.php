<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	JToolBarHelper::title(JText::_('GIFTCARD CSV MANAGER'), 'pict.png' );		
	JToolBarHelper::save();
	JToolBarHelper::deleteList();
?>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
	<table>
        <tr>
            <td>
				<strong><?php echo JText::_( 'File' ); ?></strong> <input type="file" name="file" id="file" class="inputbox"/>
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
					<?php echo JHTML::_('grid.sort', JText::_('CARD PASSWORD'), 'a.password', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('NOMINAL'), 'a.nominal', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>					
				<th nowrap="nowrap" width="3%">
					<?php echo JHTML::_('grid.sort', JText::_('ACTIVE'), 'a.published', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th nowrap="nowrap" width="3%">
					<?php echo JHTML::_('grid.sort', JText::_('Used'), 'a.used', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>							
				<th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'a.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>			
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row 	=& $this->items[$i];
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
					<?php echo $row->password; ?>
				</td>
                <td>
					<?php echo $row->nominal; ?>
				</td>	
                <td align="center">
					<?php echo $published; ?>
				</td>
                <td align="center">
					<?php echo $row->used ? '<img src="images/tick.png" width="16" height="16" border="0" alt="" />': ''; ?>
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
	<input type="hidden" name="controller" value="giftcardcsv" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>


