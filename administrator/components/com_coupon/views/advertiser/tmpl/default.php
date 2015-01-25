<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php?option=com_coupon&task=advertiser&controller=event&tmpl=component&object=advertiser" method="post" name="adminForm">
	<table>
		<tr>
			<td>
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
				<th class="title">
					<?php echo JHTML::_('grid.sort', JText::_('Title'), 'a.username', $this->lists['order_Dir'], $this->lists['order'] ); ?>
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
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
                <td>
					<a style="cursor: pointer;" onclick="window.parent.jSelectArticle('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""), $row->name.' '.$row->family.'(<a href="index.php?option=com_users&view=user&task=edit&cid[]='.$row->id.'">'.$row->username.'</a>)'); ?>', '<?php echo JRequest::getVar('object'); ?>');"><?php echo $row->username; ?> (<?php echo $row->name; ?> <?php echo $row->family; ?>)</a>
				</td>
                <td>
					<a style="cursor: pointer;" onclick="window.parent.$('<?php echo $row->idmovie; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->title); ?>', '<?php echo JRequest::getVar('object'); ?>');"><?php echo $row->id; ?></a>
				</td>
			</tr>
			
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>


