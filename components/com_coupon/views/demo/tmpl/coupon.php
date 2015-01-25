<?php defined('_JEXEC') or die('Restricted access');?>
<style type="text/css">
html{direction:inherit;padding:20px;}
body{direction:inherit;}
table{padding:0;margin:0;}
#body{width:650px;font:normal 13px Tahoma, Geneva, sans-serif;color:#000;text-align:left;padding:20px 50px 30px 50px;border:2px #ccc solid;}
#coupon{height:100px;}
#logo{float:left;}
#clientInfo{float:right;font-size:14px;padding:0 30px 0 0;}
#clientInfo span{background:#fff2b4;padding:0 3px 0 3px;}
#title{padding:10px 0 10px 0;border-top:1px #e5e5e5 solid;border-bottom:1px #e5e5e5 solid;margin:0 0 15px 0;}
.title{font-size:24px;padding:0 0 0 10px;}
.big{font-size:15px;font-weight:bold;padding:0 0 15px 0;}
#terms ul{padding:0;margin:0;}
#terms li{background:url(<?php echo JURI::root();?>images/pic.png) left 5px no-repeat;padding:0 0 15px 20px;margin:0;list-style:none;}
</style>
<center>
	<div id="body">
    	<div id="coupon">
			<div id="logo"><img src="images/logo_small.jpg" /></div>
            <div id="clientInfo">
            	<div><strong><?php echo JText::_('Client'); ?>: <?php echo $this->user->name; ?> <?php echo $this->user->family; ?></strong></div>
                <div><?php echo JText::_('Number your coupon');?>: <span style="background:#fff2b4;padding:0 3px 0 3px;"><?php echo $this->items->password;?></span></div>
                <div align="right"><img src="<?php echo JURI::base();?>barcode.php?code=<?php echo $this->items->password; ?>" /></div>
            </div>
        </div>
        <div id="title">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td width="1%">
                    	<img src="images/events/<?php echo $this->items->image; ?>" style="padding:2px;border:1px #cdcdcd solid;" />
                    </td>
                    <td class="title">
                    	<?php echo $this->items->title; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div id="terms">
        	<table cellpadding="4" cellspacing="0" width="100%">
            	<tr>
                	<td width="50%" style="vertical-align:top;">
                        <div class="big"><?php echo JText::_('Terms'); ?></div>
                        <ul><?php echo $this->items->terms; ?></ul>
            		</td>
                    <td width="50%" style="vertical-align:top;">
                        <div class="big"><?php echo JText::_('Features'); ?></div>
            			<ul><?php echo $this->items->features; ?></ul>
            		</td>
                </tr>
            </table>
        </div>
    	<div id="main">
			<div class="big"><?php echo JText::_('Map'); ?></div>
            <div>
				<?php $config = new JConfig();?>
            	<img height="350" src="http://static-maps.yandex.ru/1.x/?key=<?php echo $config->yandex_key; ?>&amp;l=map&amp;zoom=<?php echo $this->params->get( 'scale' ); ?>&amp;size=650,350&amp;ll=<?php echo $this->params->get( 'y' ); ?>,<?php echo $this->params->get( 'x' ); ?>&amp;pt=<?php echo $this->map; ?>" width="650" />
            </div>
		</div>
    </div>
</center>
<script type='text/javascript'>
  //<![CDATA[
    window.onload = function() {
       setTimeout(function() { window.print() }, 100)
    }
  //]]>
</script>   