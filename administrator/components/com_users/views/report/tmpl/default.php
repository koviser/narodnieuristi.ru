<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<form action="index.php" method="post" name="adminForm" autocomplete="off">
	<div>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'Report' ); ?></legend>
			<table class="admintable" cellspacing="1">
				<tr>
					<td width="150" class="key">
						<?php echo JText::_( 'Date start' ); ?>
					</td>
					<td>
						<?php echo $this->lists['dateStart']; ?>
					</td>
                    <td width="150" class="key">
						<?php echo JText::_( 'Date end' ); ?>
					</td>
					<td>
						<?php echo $this->lists['dateEnd']; ?>
					</td>
				</tr>
                <tr>
                    <td colspan="4" align="right";>
						<input type="submit" value="Ok" />
					</td>
				</tr>
			</table>
            <?php if($this->report){?>
            	<table class="admintable" cellspacing="1">
            	<?php if($this->user->partner==1){?>
            		<tr>
                        <td width="150" class="key">
                            <?php echo JText::_( 'Count ref' ); ?>
                        </td>
                        <td>
                            <?php echo $this->row->total; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <?php echo JText::_( 'Money' ); ?>
                        </td>
                        <td>
                            <?php echo $this->row->summ; ?> <?php echo JText::_( 'rub' ); ?>
                        </td>
                    </tr>
                <?php }else if($this->user->partner==2){ ?>
                	<tr>
                        <td width="150" class="key">
                            <?php echo JText::_( 'Count buying' ); ?>
                        </td>
                        <td>
                            <?php echo $this->row->total; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <?php echo JText::_( 'Summ buying' ); ?>
                        </td>
                        <td>
                            <?php echo number_format(($this->row->summ/$this->user->reward*100),2,'.',''); ?> <?php echo JText::_( 'rub' ); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <?php echo JText::_( 'Money' ); ?>
                        </td>
                        <td>
                            <?php echo $this->row->summ; ?> <?php echo JText::_( 'rub' ); ?>
                        </td>
                    </tr>
                <?php }else if($this->user->partner==3){ ?>
                	<tr>
                        <td width="150" class="key">
                            <?php echo JText::_( 'Count buying' ); ?>
                        </td>
                        <td>
                            <?php echo $this->row->total; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <?php echo JText::_( 'Summ buying' ); ?>
                        </td>
                        <td>
                            <?php echo number_format(($this->row->summ/$this->user->reward*100),2,'.',''); ?> <?php echo JText::_( 'rub' ); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <?php echo JText::_( 'No buying' ); ?>
                        </td>
                        <td>
                            <?php echo $this->row->users; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" class="key">
                            <?php echo JText::_( 'Money' ); ?>
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
	<input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="report" value="1" />
	<input type="hidden" name="view" value="report" />
    <input type="hidden" name="tmpl" value="component" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
