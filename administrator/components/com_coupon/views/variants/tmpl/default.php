<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
	$document = &JFactory::getDocument();
	$document->addStyleSheet('templates/system/css/system.css');
	$document->addStyleSheet('templates/khepri/css/template.css');			
?>
<script type="text/javascript">
		window.addEvent('domready', function() {
			var total = window.parent.$('total');
			total.setHTML(<?php echo $this->pagination->total; ?>);
		});
</script>
<form action="index.php" method="post" name="adminForm">

<div class="m">
	<div class="toolbar" id="toolbar">
		<table class="toolbar">
        	<tr>
				<td class="button" id="toolbar-delete">
                        <a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Выберите из списка для');}else{  submitbutton('remove')}" class="toolbar">
                        <span class="icon-32-delete" title="<?php echo JText::_('Delete'); ?>">
                        </span>
                        <?php echo JText::_('Delete'); ?>
					</a>
				</td>
				<td class="button" id="toolbar-edit">
					<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Выберите из списка для');}else{ hideMainMenu(); submitbutton('edit')}" class="toolbar">
						<span class="icon-32-edit" title="<?php echo JText::_('Edit'); ?>">
						</span>
                    	<?php echo JText::_('Edit'); ?>
                    </a>
				</td>
				<td class="button" id="toolbar-new">
					<a href="#" onclick="javascript:hideMainMenu(); submitbutton('add')" class="toolbar">
                        <span class="icon-32-new" title="<?php echo JText::_('Add'); ?>">
                        </span>
                        <?php echo JText::_('Add'); ?>
                    </a>
				</td>
			</tr>
		</table>
	</div>
	<div class="header icon-48-pict">
		<?php echo JText::_('VARIANT MANAGER'); ?>
	</div>
</div>
	
	<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="1%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="1%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				</th>				
				<th class="title" style="text-align:left;">
					<?php echo JHTML::_('grid.sort', JText::_('VARIANT NAME'), 'a.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
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
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row 	=& $this->items[$i];
				$link 	= 'index.php?option=com_coupon&amp;controller=variant&amp;view=variant&amp;task=edit&amp;cid[]='.$row->id.'&amp;option_id='.$this->option_id.'&amp;tmpl=component';
				
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td align="center">
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>">
						<?php echo $row->title; ?></a>
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
	<input type="hidden" name="controller" value="variant" />
	<input type="hidden" name="task" value="" />	
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
    <input type="hidden" name="option_id" value="<?php echo $this->option_id; ?>" />
    <input type="hidden" name="tmpl" value="component" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>


