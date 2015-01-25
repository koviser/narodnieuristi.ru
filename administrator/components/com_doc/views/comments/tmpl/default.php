<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	JToolBarHelper::title(JText::_('Comments MANAGER'), 'frontpage' );		
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
				<th class="title" width="1%">
					<?php echo JHTML::_('grid.sort', JText::_('IMAGE'), 'a.image', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('NAME'), 'a.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('Comment'), 'a.text', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>							
				<th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'a.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			$i = 0;
			$n = count( $this->items );
			$rows = &$this->items;

			foreach ($rows as $row){
				$link 	= 'index.php?option=com_doc&amp;controller=comments&amp;view=comment&amp;task=edit&amp;cid[]='. $row->id. '';
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="center">
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td>
                	<?php if($row->image){ ?>
					<a href="<?php echo $link; ?>"><img src="../<?php echo $row->image; ?>" /></a>
                    <?php } ?>
				</td>
                <td>
					<a href="<?php echo $link; ?>"><?php echo $row->name; ?></a>
				</td>
                <td>
					<a href="<?php echo $link; ?>"><?php echo $row->text; ?></a>
				</td>																										
				<td>
					<?php echo $row->id; ?>
				</td>
			</tr>
			
			<?php
					$k = 1 - $k;
					$i++;
				}
			?>
		</tbody>
	</table>
	
	<input type="hidden" name="option" value="com_doc" />
	<input type="hidden" name="controller" value="comments" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>


