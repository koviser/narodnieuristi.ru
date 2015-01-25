<?php defined('_JEXEC') or die('Restricted access');?>
<?php JHTML::_('behavior.tooltip'); ?>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->escape($this->params->get('page_title')); ?></div>
    <div id="tabPanel">
    	<a href="index.php?option=com_user"><?php echo JText::_( 'My coupons' ); ?></a>
        <a href="index.php?option=com_user&layout=billing"><?php echo JText::_( 'Billing' ); ?></a>
        <a href="index.php?option=com_user&layout=bonuses"><?php echo JText::_( 'Bonuses' ); ?></a>
        <a href="index.php?option=com_user&layout=edit"><?php echo JText::_( 'Personal info' ); ?></a>
        <a href="index.php?option=com_user&layout=friends"><?php echo JText::_( 'Friends' ); ?></a>
<a href="index.php?option=com_user&layout=giftcard"><?php echo JText::_('Gift card');?></a>
        <?php if($this->user->advertiser==1){ ?>
        <a href="index.php?option=com_user&layout=myevents"><?php echo JText::_( 'My events' ); ?></a>
        <?php } ?><?php if($this->user->partner){ ?>
         <span><?php echo JText::_( 'My partner' ); ?></span>
        <?php } ?>
    </div>
	<div id="personalText">
		<p><strong><?php echo JText::_( 'My ref' ); ?></strong> : ?ref=<?php echo base64_encode('user'.$this->user->partner.'_'.$this->user->id);?></p>
<form action="index.php" method="post" name="adminForm" autocomplete="off">
	<div>
		<fieldset class="adminform fildset">
		<legend><?php echo JText::_( 'Report' ); ?></legend>
			<table class="admintable" cellspacing="4" cellspacing="0">
				<tr>
					<td class="key" align="right">
						<strong><?php echo JText::_( 'Date start' ); ?></strong>
					</td>
					<td>
						<?php echo $this->lists['dateStart']; ?>
					</td>
                    <td class="key" align="right">
						<strong><?php echo JText::_( 'Date end' ); ?></strong>
					</td>
					<td>
						<?php echo $this->lists['dateEnd']; ?>
					</td>
				</tr>
                <tr>
                    <td colspan="4" align="right">
						<input type="submit" class="button" value="Ok" />
					</td>
				</tr>
			</table>
            <?php if($this->report){?>
            	<table class="admintable" cellspacing="1">
            	<?php if($this->user->partner==1){?>
            		<tr>
                        <td width="150" class="key">
                            <strong><?php echo JText::_( 'Count ref' ); ?></strong>
                        </td>
                        <td>
                            <?php echo $this->row->total; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <strong><?php echo JText::_( 'Money' ); ?></strong>
                        </td>
                        <td>
                            <?php echo $this->row->summ; ?> <?php echo JText::_( 'rub' ); ?>
                        </td>
                    </tr>
                <?php }else if($this->user->partner==2){ ?>
                	<tr>
                        <td width="150" class="key">
                            <strong><?php echo JText::_( 'Count buying' ); ?></strong>
                        </td>
                        <td>
                            <?php echo $this->row->total; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <strong><?php echo JText::_( 'Summ buying' ); ?></strong>
                        </td>
                        <td>
                            <?php echo number_format(($this->row->summ/$this->user->reward*100),2,'.',''); ?> <?php echo JText::_( 'rub' ); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <strong><?php echo JText::_( 'Money' ); ?></strong>
                        </td>
                        <td>
                            <?php echo $this->row->summ; ?> <?php echo JText::_( 'rub' ); ?>
                        </td>
                    </tr>
                <?php }else if($this->user->partner==3){ ?>
                	<tr>
                        <td width="150" class="key">
                            <strong><?php echo JText::_( 'Count buying' ); ?></strong>
                        </td>
                        <td>
                            <?php echo $this->row->total; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <strong><?php echo JText::_( 'Summ buying' ); ?></strong>
                        </td>
                        <td>
                            <?php echo number_format(($this->row->summ/$this->user->reward*100),2,'.',''); ?> <?php echo JText::_( 'rub' ); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <strong><?php echo JText::_( 'No buying' ); ?></strong>
                        </td>
                        <td>
                            <?php echo $this->row->users; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <strong><?php echo JText::_( 'Money' ); ?></strong>
                        </td>
                        <td>
                            <?php echo $this->row->summ; ?> <?php echo JText::_( 'rub' ); ?>
                        </td>
                    </tr>
                <?php } ?>
                </table>
            <?php } ?>
		</fieldset>
	</div>
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="report" value="1" />
	<input type="hidden" name="view" value="user" />
    <input type="hidden" name="layout" value="partner" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
	</div>
</div></div></div>