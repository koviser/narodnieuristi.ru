<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	JToolBarHelper::title(JText::_('transaction MANAGER'), 'frontpage' );
?>
<form action="index.php" method="post" name="adminForm">
	<table width="100%">
		<tr>
			<td width="50%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
            <td width="50%" align="right">
				<?php echo JText::_( 'Type' ); ?>:
				<?php echo $this->lists['type']; ?>
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
					<?php echo JHTML::_('grid.sort', JText::_('User'), 'u.email', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('date'), 'a.date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>	
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('sum'), 'a.sum', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>	
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('type'), 'a.type', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('ID event'), 'a.eventid', $this->lists['order_Dir'], $this->lists['order'] ); ?>
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
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td>
					<?php echo $row->email; ?> (ID <?php echo $row->userid; ?>)
				</td>
                <td align="center">
					<?php echo $row->date; ?>
				</td>
                <td align="center">
					<?php echo $row->sum; ?>
				</td>	
                <td align="center">
					<?php echo $row->type; ?>
				</td>
                <td align="center">
					<?php echo $row->eventid; ?>
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
    <strong><?php echo JText::_('TYPES'); ?>:</strong><br/>
    1 - <?php echo JText::_('TYPE_1'); ?> &nbsp;&nbsp;
	2 - <?php echo JText::_('TYPE_2'); ?> &nbsp;&nbsp;
	3 - <?php echo JText::_('TYPE_3'); ?> &nbsp;&nbsp;
	4 - <?php echo JText::_('TYPE_4'); ?> &nbsp;&nbsp;
	5 - <?php echo JText::_('TYPE_5'); ?> &nbsp;&nbsp;
    6 - <?php echo JText::_('TYPE_6'); ?> &nbsp;&nbsp;
    7 - <?php echo JText::_('TYPE_7'); ?> &nbsp;&nbsp;
    8 - <?php echo JText::_('TYPE_8'); ?> &nbsp;&nbsp;
    9 - <?php echo JText::_('TYPE_9'); ?> &nbsp;&nbsp;
    10 - <?php echo JText::_('TYPE_10'); ?>
	
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="controller" value="transaction" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>


