<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	$user = JFactory::getUser();
	//if($this->lists['order']=='a.ordering' && $this->lists['order_Dir']=='desc'){ $order= 1;}
	JToolBarHelper::title(JText::_('CLIENTS MANAGER'), 'frontpage' );
	JToolBarHelper::customX( 'xls', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD XLS' ), false );
	//JToolBarHelper::customX( 'copyEvent', 'copy.png', 'copy_f2.png', JText::_( 'copy' ), false );	
	if($user->gid==25)
		JToolBarHelper::deleteList();
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();
	//JToolBarHelper::preferences('com_doc', '500');
?>
<form action="index.php" method="post" name="adminForm">
	<!--
	<table width="100%" cellpadding="4">
		<tr>
        	<!--
			<td width="50%">
				<?php echo JText::_( 'Event status' ); ?>:
				<?php echo $this->lists['status']; ?>
			</td>
            		
            <td width="1%" nowrap="nowrap" align="right">
				<?php echo JText::_( 'Category' ); ?>:
				<?php echo $this->lists['category']; ?>
			</td>				
		</tr>
	</table>
    -->	
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
					<?php echo JHTML::_('grid.sort', JText::_('NAME'), 'a.client_name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('PHONE'), 'a.client_phone', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('TYPE'), 't.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('NUMBER'), 'a.number', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <!--
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('DATE_CONTRACT'), 'a.date_contract', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                -->	
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('DATE_ADMISSION'), 'a.date_admission', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('NAME_CONSULTANT'), 'c.name', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>	
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('DEFENDANT'), 'a.defendant', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>	
                <th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('PRICE'), 'a.price', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>							
				<th width="1%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   JText::_('ID'), 'a.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
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
				$link 	= 'index.php?option=com_doc&amp;controller=client&amp;view=client&amp;task=edit&amp;cid[]='. $row->id. '';
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td nowrap="nowrap">
					<a href="<?php echo $link; ?>"><?php echo $row->client_name; ?></a>
				</td>
                <td align="center">
					<?php echo $row->client_phone; ?>
				</td>   
                <td align="center">
					<?php echo $row->type; ?>
				</td>
                <td align="center">
					<?php echo $row->number; ?>
				</td>
                <!--
                <td align="center">
					<?php echo $row->date_contract; ?>
				</td>
                -->
                <td align="center">
					<?php echo $row->date_admission; ?>
				</td>
                <td align="center" nowrap="nowrap">
					<?php echo $row->consultant; ?>
				</td>
                <td align="center">
					<?php echo $row->defendant; ?>
				</td>
                <td align="center">
					<?php echo $row->price; ?>
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
	
	<input type="hidden" name="option" value="com_doc" />
	<input type="hidden" name="controller" value="client" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>


