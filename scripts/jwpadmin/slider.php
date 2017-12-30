<?php 
if(realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
if(is_admin()):
?>
<form method="post">
	<div class="padd">
    	 <?php $issl = $wpdb->get_var("SELECT COUNT(id) as cnt FROM ".$wpdb->prefix."jwp_settings WHERE jwp_action ='sl'"); ?>
    	 <input type="submit" class="right" name="<?php echo ($issl > 0)? "slon" : "sloff";  ?>" value="<?php echo ($issl > 0)? "Disable" : "Enable";  ?>" />
         <span class="modtitle left">Master Swiper 2.0</span>
         <div class="clear"></div>
	</div>
    <?php
		$ifen = (($issl > 0))? NULL : "style=\"display:none;\"";
	?>
    <div class="padd">
        <div class="modcontent slider_">
            <div align="left">Note: This is a lite version for template usage purpose only. For full functionalities please visit the <a href="http://www.idangero.us/sliders/swiper/index.php" target="_blank">site.</a></div>
        	<div <?php _e($ifen); ?>>
            <?php
                $getcon = $wpdb->get_row("SELECT id, slide_target, slide_autoplay, slide_speed FROM ".$wpdb->prefix."jwp_settings WHERE jwp_action = 'sl'");
            ?>
            <p><input type="checkbox" name="autoplay" id="autoplay" value="Y" <?php echo ($getcon->slide_autoplay == 'Y')? "checked=\"checked\"" : NULL; ?>  />&nbsp;Autoplay</p>
            <p><input type="text" name="speed" value="<?php _e($getcon->slide_speed); ?>" placeholder="Speed" style="width:200px;"/></p>
            <p><input type="submit" name="slider" value="Save Changes" /></p>
            <p><input type="hidden" name="hiddenslid" value="<?php _e($getcon->id); ?>" /></p>
            </div>
        
        <div class="left" style="width:50%;"></div>
        <div class="clear"></div>
    </div>
	</div>
 </form>
 <?php 
endif;
 ?>
