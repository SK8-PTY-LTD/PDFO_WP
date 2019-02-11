<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
?>
<div class="property-info-footer">
	<span class="property-date">
		<i class="fa fa-calendar accent-color"></i> <?php echo get_the_time(get_option('date_format')); ?>
	</span>
	<span class="property-views-count">
		<i class="fa fa-eye accent-color"></i>
		<?php
		$ere_property=new ERE_Property();
		$total_views= $ere_property->get_total_views($post->ID);
		printf( _n( '%s view', '%s views', $total_views, 'essential-real-estate' ), ere_get_format_number($total_views ));
		?>
	</span>
</div>