<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
<?php endif; ?>
<div id="userForm">
	<div id="userDetails">
    	<div id="userLeft">
        	<table cellpadding="5" cellspacing="0" width="100%">
            	<tr>
                	<td width="1%" nowrap="nowrap" class="black"><?php echo JText::_( 'Name' ); ?> :</td>
                    <td><?php echo $this->user->name; ?></td>
                    <td><a href="index.php?option=com_user&layout=edit"><?php echo JText::_( 'Edit profile' ); ?></a></td>
                </tr>
                <tr>
                	<td nowrap="nowrap" class="black"><?php echo JText::_( 'Gender' ); ?> :</td>
                    <td><?php echo JEventsCommon::Gender($this->user->gender); ?></td>
                    <td><a href="index.php?option=com_user&layout=password"><?php echo JText::_( 'Edit password' ); ?></td>
                </tr>
                <tr>
                	<td nowrap="nowrap" class="black"><?php echo JText::_( 'E-mail' ); ?> :</td>
                    <td><?php echo $this->user->email; ?></td>
                    <td><a href="index.php?option=com_user&layout=subscribe"><?php echo JText::_( 'Edit subscribe' ); ?></td>
                </tr>
                <tr>
                	<td nowrap="nowrap" class="black"><?php echo JText::_( 'Birthday' ); ?> :</td>
                    <td><?php echo JEventsCommon::GetBirthDay($this->user->birthDay); ?></td>
                    <td></td>
                </tr>
                <tr>
                	<td nowrap="nowrap" class="black"><?php echo JText::_( 'Subscribe' ); ?> :</td>
                    <td><?php echo JEventsCommon::Subscribe($this->user->sendEmail); ?></td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div id="userRight">
        	<?php echo JText::_( 'Bonus' ); ?>
        	<div><?php echo $this->user->bonus; ?></div>
            <a href="index.php?option=com_coupon&view=bonuses">Что я могу с ними сделать?</a>
        </div>
    </div>
    <div id="userTitle">
    	<?php echo JEventsCommon::ArhiveTitle($this->params->get( 'month' ));?>
    </div>
    <div id="userActions">
    	<div id="userCalendar">
			<?php
                $month="&month=".$this->params->get( 'month' );
                $monthTitle=JEventsCommon::GetMonth($this->params->get('month'));
                $start=date("n", mktime(0, 0, 0, date("m")-11  , 1, date("Y")));
				for($i=$start;$i<($start+12);$i++){
					$j=$i%12;
					if($j==0)$j=12;
                    if($j==$this->params->get( 'month' )){
                        $class=' class="activeM"';
                    }else{
                        $class="";
                    }
                    $count = $this->month[$j]->count ? $this->month[$j]->count : 0;
            ?>
                <?php if($count>0){ ?>
                    <a href="index.php?option=com_user&m=<?php echo $j;?>"<?php echo $class;?>><?php echo JText::_('Month_'.$j);?> (<?php echo $count; ?>)</a>
                <?php }else{ ?>
                    <span><?php echo JText::_('Month_'.$j);?></span>
                <?php } ?>
                <?php if($i!=($start+11)){ ?>
                    <div class="spacerM"></div>
                <?php } ?>
            <?php } ?>
        </div>
        <div id="userStatistic">
        	<table cellpadding="0" cellspacing="0" width="100%" id="historyTable"> 
			<?php for($i=0;$i<count($this->items);$i++){ 
                $row=$this->items[$i];
            ?>
                <tr>
                	<td class="hDate">
                    	<div class="dateA">
                        	<?php echo $monthTitle;?>
                            <div><?php echo $row->day;?></div>
                        </div>
                    </td>
                    <td class="hTitle">
                    	<?php if($row->type==1){ ?>
                        	<a href="index.php?option=com_coupon&view=bonus&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
                        <?php }else{ ?>
                    		<a href="index.php?option=com_coupon&view=event&id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
                        <?php } ?>
                        <div><?php echo JEventsCommon::GetDatePaid($row->date); ?> | <?php echo JEventsCommon::GetDateEndHistory($row->dateUsed); ?></div>
                        <?php if($row->type==1){ ?>
                        	<div class="bonusA"><?php echo JText::_('Bonus Actions');?></div>
                        <?php } ?>
                    </td>
                    <td class="hSale">
                    	<?php echo JText::_('Discount');?><br/>
                        <span><?php echo $row->sale; ?> %</span>
                    </td>
                    <td class="hCoupon">
                    	<?php echo JText::_('Coupon');?><br/>
                        <div id="couponN"><?php echo $row->password; ?></div>
                        <img src="templates/skidking/images/print.jpg" align="absmiddle" alt="<?php echo JText::_('Print');?>" />
                        <a href="index.php?option=com_coupon&view=event&tmpl=component&layout=coupon&id=<?php echo $row->coupon; ?>"><?php echo JText::_('Print Coupon');?></a>
                    </td>
            	</tr>
            <?php } ?>
            </table>
        </div>
    </div>
</div>
