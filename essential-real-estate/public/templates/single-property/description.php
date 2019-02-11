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
$content = get_the_content();
if (isset($content) && !empty($content)): ?>
<div class="ere-heading-style2 mg-bottom-35 text-left">
    <h2><?php esc_html_e( 'Description', 'essential-real-estate' ); ?></h2>
</div>
<div class="property-description mg-bottom-45 sm-mg-bottom-25">
    <?php the_content(); ?>
</div>
<?php endif; ?>