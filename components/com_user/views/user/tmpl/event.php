<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->escape($this->params->get('page_title')); ?></div>
    <div id="tabPanel">
    	<a href="index.php?option=com_user"><?php echo JText::_( 'My coupons' ); ?></a>
        <a href="index.php?option=com_user&layout=billing"><?php echo JText::_( 'Billing' ); ?></a>
        <a href="index.php?option=com_user&layout=edit"><?php echo JText::_( 'Personal info' ); ?></a>
        
<a href="index.php?option=com_user&layout=giftcard"><?php echo JText::_('Gift card');?></a>
        <?php if($this->user->advertiser==1){ ?>
        <a href="index.php?option=com_user&layout=myevents"><?php echo JText::_( 'My events' ); ?></a>
        <?php } ?>
        <?php if($this->user->partner){ ?>
         <a href="index.php?option=com_user&layout=partner"><?php echo JText::_( 'My partner' ); ?></a>
        <?php } ?>
    </div>
	<div id="personalText">
    <form action="<?php echo JRoute::_('index.php?option=com_user&view=user&layout=event&id='.$this->event->id);?>" name="searchCoupon" method="post">
    <?php 
		$count=count($this->items);
		if($count<1){
	?>
        <div id="noCoupon"><?php echo JText::_('No orders');?></div>
    <?php }else{ ?>
    	    <div class="filter">
            	<?php echo JText::_( 'Filter' ); ?>:
                <input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="inputbox" onchange="document.adminForm.submit();" />
                <button onclick="this.form.submit();" class="Submit"><?php echo JText::_( 'Go' ); ?></button>
                <button onclick="document.getElementById('search').value='';this.form.submit();" class="Submit"><?php echo JText::_( 'Reset' ); ?></button>
            </div>
        	<table cellpadding="8" cellspacing="0" width="100%" id="historyTable">
            	<tr class="class2">
                    <th width="1%" class="title" style="text-align:center;">
						<?php echo JText::_( 'NUM' ); ?>
                    </th>			
                    <th class="title" style="text-align:center;">
                        <?php echo JText::_('date'); ?>
                    </th>
                    <th class="title" style="text-align:center;">
                        <?php echo JText::_('Email'); ?>
                    </th>
                    <th class="title" style="text-align:center;">
                        <?php echo JText::_('Password'); ?>
                    </th>
                    <th class="title" style="text-align:center;">
                        <?php echo JText::_('Status'); ?>
                    </th>									
                </tr> 
			<?php for($i=0;$i<count($this->items);$i++){ 
                $row=$this->items[$i];
				$status	= JHTML::_('grid.publishedExtFront', $row->use, $row->id);
            ?>
                <tr class="<?php echo "row$k"; ?>">
				<td style="text-align:center;">
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
                <td style="text-align:center;">
					<?php echo $row->date; ?>
				</td>
                <td style="text-align:center;">
					<?php echo $row->email; ?>
				</td>	
                <td style="text-align:center;">
					<?php echo $row->password; ?>
				</td>
                <td style="text-align:center;">
					<?php echo $status; ?>
				</td>																										
			</tr>
            <?php } ?>
            </table>
    	<?php } ?>
	</div>
    </form>
</div></div></div>