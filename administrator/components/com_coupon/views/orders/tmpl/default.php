<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	JToolBarHelper::title(JText::_('ORDER MANAGER'), 'frontpage' );
	JToolBarHelper::customX( 'moneyback', 'pay.png', 'pay_f2.png', JText::_( 'moneyback' ), false );		
?>
<form action="index.php" method="post" name="adminForm">
	<table>
		<tr>
			<td width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
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
					<?php echo JHTML::_('grid.sort', JText::_('TITLE'), 'b.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('date'), 'a.date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('Email'), 'a.email', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('Password'), 'a.password', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('Status'), 'b.use', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort', JText::_('Money back possibility'), 'b.moneyback', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>										
				<th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'a.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9">
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
				$status	= JHTML::_('grid.publishedExt', $row->use, $i);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td>
					<?php echo $row->title; ?>
				</td>
                <td align="center">
					<?php echo $row->date; ?>
				</td>
                <td align="center">
					<?php echo $row->email; ?>
				</td>	
                <td align="center">
					<?php echo $row->password; ?>
				</td>
                <td align="center">
					<?php echo $status; ?>
				</td>
                <td align="center">
					<?php if($row->moneyback){ ?>
                    	<img src="images/tick.png" />
                    <?php } ?>
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
	<input type="hidden" name="controller" value="order" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>


