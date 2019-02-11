<?php
/**
 * Created by G5Theme.
 * User: trungpq
 * Date: 15/08/2017
 * Time: 08:14 AM
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $post;
$property_meta_data = get_post_custom(get_the_ID());
$property_neighborhood = get_the_terms(get_the_ID(), 'property-neighborhood');
$property_neighborhood_arr = array();
if ($property_neighborhood) {
    foreach ($property_neighborhood as $neighborhood_item) {
        $property_neighborhood_arr[] = $neighborhood_item->name;
    }
}

$property_city = get_the_terms(get_the_ID(), 'property-city');
$property_city_arr = array();
if ($property_city) {
    foreach ($property_city as $city_item) {
        $property_city_arr[] = $city_item->name;
    }
}

$property_state = get_the_terms(get_the_ID(), 'property-state');
$property_state_arr = array();
if ($property_state) {
    foreach ($property_state as $state_item) {
        $property_state_arr[] = $state_item->name;
    }
}

$property_location = get_post_meta(get_the_ID(), ERE_METABOX_PREFIX . 'property_location', true);
$property_address = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_address']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_address'][0] : '';
$property_country = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_country']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_country'][0] : '';
$property_zip = isset($property_meta_data[ERE_METABOX_PREFIX . 'property_zip']) ? $property_meta_data[ERE_METABOX_PREFIX . 'property_zip'][0] : '';
?>
<div class="ere-heading-style2 mg-bottom-35 text-left">
    <h2><?php esc_html_e('Address', 'essential-real-estate'); ?></h2>
</div>
<div class="property-location mg-bottom-45 sm-mg-bottom-25">
    <?php if (!empty($property_address)): ?>
        <div class="property-address">
            <strong><?php esc_html_e('Address:', 'essential-real-estate'); ?></strong>
            <span><?php echo esc_html($property_address) ?></span>
        </div>
    <?php endif; ?>
    <ul class="list-2-col">
        <?php if (!empty($property_country)):
            $property_country = ere_get_country_by_code($property_country); ?>
            <li>
                <strong><?php esc_html_e('Country:', 'essential-real-estate'); ?></strong>
                <span><?php echo esc_html($property_country); ?></span>
            </li>
        <?php endif;
        if (count($property_state_arr) > 0): ?>
            <li>
                <strong><?php esc_html_e('Province / State:', 'essential-real-estate'); ?></strong>
                <span><?php echo join(', ', $property_state_arr); ?></span>
            </li>
        <?php endif;
        if (count($property_city_arr) > 0): ?>
            <li>
                <strong><?php esc_html_e('City / Town:', 'essential-real-estate'); ?></strong>
                <span><?php echo join(', ', $property_city_arr); ?></span>
            </li>
        <?php endif;
        if (count($property_neighborhood_arr) > 0): ?>
            <li>
                <strong><?php esc_html_e('Suburb:', 'essential-real-estate'); ?></strong>
                <span><?php echo join(', ', $property_neighborhood_arr); ?></span>
            </li>
        <?php endif;
        if (!empty($property_zip)): ?>
            <li>
                <strong><?php esc_html_e('Postal code / ZIP:', 'essential-real-estate'); ?></strong>
                <span><?php echo esc_html($property_zip) ?></span>
            </li>
        <?php endif; ?>
    </ul>
    <?php if ($property_location):
        $google_map_address_url = "http://maps.google.com/?q=" . $property_location['address'];
        ?>
        <a class="open-on-google-maps accent-color" target="_blank"
           href="<?php echo esc_url($google_map_address_url); ?>"><?php esc_html_e('Open on Google Maps', 'essential-real-estate'); ?>
            <i class="fa fa-map-marker accent-color"></i></a>
    <?php endif; ?>
</div>