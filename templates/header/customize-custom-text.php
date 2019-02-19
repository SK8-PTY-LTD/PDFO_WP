<?php
/**
 * @var $customize_location
 */
$customize_content =  g5plus_get_option('header_customize_' . $customize_location . '_text','');
?>
<div class="header-customize-item item-custom-text">
	<p style="color:#fff;font-size:18px;line-height: 20px;text-align:center">
		<a href="javascript:void(0)" class="login-link topbar-link" data-toggle="modal" data-target="#ere_signin_modal" style="color:#fff;font-size:18px;line-height: 20px;text-align:center">
			<i style="color:#fff;font-size:18px;line-height: 20px;text-align:center" class="fa fa-clock-o"></i>
			<br> Free Registration 
		</a>
	</p>
	<?php //echo wp_kses_post($customize_content); ?>
</div>