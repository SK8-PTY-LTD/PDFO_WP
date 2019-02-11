<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://themeforest.net/user/G5Themes
 * @since      1.0.0
 *
 * @package    Essential_Real_Estate
 * @subpackage Essential_Real_Estate/includes
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('ERE_Template_Hooks')) {
    /**
     * Class ERE_Template_Hooks
     */
    require_once ERE_PLUGIN_DIR . 'includes/class-ere-loader.php';

    class ERE_Template_Hooks
    {
        protected $loader;
        /**
         * Instance variable for singleton pattern
         */
        private static $instance = null;

        /**
         * Return class instance
         * @return ERE_Template_Hooks|null
         */
        public static function get_instance()
        {
            if (null == self::$instance) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function __construct()
        {
            $this->loader = new ERE_Loader();
            $this->loader->add_action('ere_before_main_content', $this, 'output_content_wrapper_start', 10);
            $this->loader->add_action('ere_after_main_content', $this, 'output_content_wrapper_end', 10);
            //property_sidebar
            $this->loader->add_action('ere_sidebar_property', $this, 'sidebar_property', 10);
            $this->loader->add_action('ere_sidebar_agent', $this, 'sidebar_agent', 10);
            $this->loader->add_action('ere_sidebar_invoice', $this, 'sidebar_invoice', 10);

            //Archive Property
            $this->loader->add_action('ere_archive_property_before_main_content', $this, 'archive_property_search', 10);
            $this->loader->add_action('ere_archive_property_heading', $this, 'archive_property_heading', 10, 4);
            $this->loader->add_action('ere_archive_property_action', $this, 'archive_property_action', 10, 1);
            $this->loader->add_action('ere_loop_property', $this, 'loop_property', 10, 2);
            //Advanced Search
            $this->loader->add_action('ere_advanced_search_before_main_content', $this, 'advanced_property_search', 10);
            //Archive Agent
            $this->loader->add_action('ere_archive_agent_heading', $this, 'archive_agent_heading', 10, 1);
            $this->loader->add_action('ere_archive_agent_action', $this, 'archive_agent_action', 10, 1);
            $this->loader->add_action('ere_loop_agent', $this, 'loop_agent', 10, 3);

            //Single Property
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_header', 5);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_gallery', 10);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_description', 15);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_location', 20);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_features', 25);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_floors', 30);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_attachments', 35);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_map_directions', 40);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_nearby_places', 45);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_walk_score', 50);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_contact_agent', 55);
            $this->loader->add_action('ere_single_property_summary', $this, 'single_property_footer', 90);

            $enable_comments_reviews_property = ere_get_option('enable_comments_reviews_property', 1);
            if ($enable_comments_reviews_property == 1) {
                $this->loader->add_action('ere_single_property_after_summary', $this, 'comments_template', 95);
            }
            if ($enable_comments_reviews_property == 2) {
                $this->loader->add_action('ere_single_property_summary', $this, 'single_property_reviews', 95);
            }

            //Single Agent
            $this->loader->add_action('ere_single_agent_summary', $this, 'single_agent_info', 5);

            $enable_comments_reviews_agent = ere_get_option('enable_comments_reviews_agent', 0);
            if ($enable_comments_reviews_agent == 1) {
                $this->loader->add_action('ere_single_agent_summary', $this, 'comments_template', 15);
            }
            if ($enable_comments_reviews_agent == 2) {
                $this->loader->add_action('ere_single_agent_summary', $this, 'single_agent_reviews', 15);
            }
            $this->loader->add_action('ere_single_agent_summary', $this, 'single_agent_property', 20);
            $this->loader->add_action('ere_single_agent_summary', $this, 'single_agent_other', 30);

            //Author
            $this->loader->add_action('ere_author_summary', $this, 'author_info', 5);
            $this->loader->add_action('ere_author_summary', $this, 'author_property', 10);

            //Single Invoice
            $this->loader->add_action('ere_single_invoice_summary', $this, 'single_invoice', 10);
            //Taxonomy
            $this->loader->add_action('ere_taxonomy_agency_summary', $this, 'taxonomy_agency_detail', 10);
            $this->loader->add_action('ere_taxonomy_agency_agents', $this, 'taxonomy_agency_agents', 10, 1);
            //Property Action
            $this->loader->add_action('ere_property_action', $this, 'property_view_gallery', 5);
            $this->loader->add_action('ere_property_action', $this, 'property_favorite', 10);
            $this->loader->add_action('ere_property_action', $this, 'property_compare', 15);
            $this->loader->run();
        }

        /**
         * output_content_wrapper
         */
        public function output_content_wrapper_start()
        {
            ere_get_template('global/wrapper-start.php');
        }

        /**
         * output_content_wrapper
         */
        public function output_content_wrapper_end()
        {
            ere_get_template('global/wrapper-end.php');
        }

        /**
         * archive_property_search
         */
        public function archive_property_search()
        {
            $enable_archive_search_form = ere_get_option('enable_archive_search_form', '0');
            if ($enable_archive_search_form == '1'):
                $hide_archive_search_fields = ere_get_option('hide_archive_search_fields', array('property_country', 'property_state', 'property_neighborhood', 'property_label'));
                if (!is_array($hide_archive_search_fields)) {
                    $hide_archive_search_fields = array();
                }
                $status_enable = !in_array("property_status", $hide_archive_search_fields);
                $type_enable = !in_array("property_type", $hide_archive_search_fields);
                $title_enable = !in_array("property_title", $hide_archive_search_fields);
                $address_enable = !in_array("property_address", $hide_archive_search_fields);
                $country_enable = !in_array("property_country", $hide_archive_search_fields);
                $state_enable = !in_array("property_state", $hide_archive_search_fields);
                $city_enable = !in_array("property_city", $hide_archive_search_fields);
                $neighborhood_enable = !in_array("property_neighborhood", $hide_archive_search_fields);
                $bedrooms_enable = !in_array("property_bedrooms", $hide_archive_search_fields);
                $bathrooms_enable = !in_array("property_bathrooms", $hide_archive_search_fields);
                $price_enable = !in_array("property_price", $hide_archive_search_fields);
                $area_enable = !in_array("property_size", $hide_archive_search_fields);
                $land_area_enable = !in_array("property_land", $hide_archive_search_fields);
                $label_enable = !in_array("property_label", $hide_archive_search_fields);
                $garage_enable = !in_array("property_garage", $hide_archive_search_fields);
                $property_identity_enable = !in_array("property_identity", $hide_archive_search_fields);
                $other_features_enable = !in_array("property_feature", $hide_archive_search_fields);
                ?>
                <div class="ere-heading-style2 mg-bottom-35 text-left">
                    <h2><?php esc_html_e('Search Property', 'essential-real-estate') ?></h2>
                </div>
                <?php
                $property_price_field_layout = ere_get_option('archive_search_price_field_layout', '0');
                $property_size_field_layout = ere_get_option('archive_search_size_field_layout', '0');
                $property_land_field_layout = ere_get_option('archive_search_land_field_layout', '0');
                echo do_shortcode('[ere_property_advanced_search layout="tab" column="3" color_scheme="color-dark" status_enable="' . ($status_enable ? 'true' : 'false') . '" type_enable="' . ($type_enable ? 'true' : 'false') . '" title_enable="' . ($title_enable ? 'true' : 'false') . '" address_enable="' . ($address_enable ? 'true' : 'false') . '" country_enable="' . ($country_enable ? 'true' : 'false') . '" state_enable="' . ($state_enable ? 'true' : 'false') . '"  city_enable="' . ($city_enable ? 'true' : 'false') . '"  neighborhood_enable="' . ($neighborhood_enable ? 'true' : 'false') . '" bedrooms_enable="' . ($bedrooms_enable ? 'true' : 'false') . '" bathrooms_enable="' . ($bathrooms_enable ? 'true' : 'false') . '" price_enable="' . ($price_enable ? 'true' : 'false') . '" price_is_slider="' . (($property_price_field_layout == '1') ? 'true' : 'false') . '" area_enable="' . ($area_enable ? 'true' : 'false') . '" area_is_slider="' . (($property_size_field_layout == '1') ? 'true' : 'false') . '" land_area_enable="' . ($land_area_enable ? 'true' : 'false') . '" land_area_is_slider="' . (($property_land_field_layout == '1') ? 'true' : 'false') . '" label_enable="' . ($label_enable ? 'true' : 'false') . '" garage_enable="' . ($garage_enable ? 'true' : 'false') . '" property_identity_enable="' . ($property_identity_enable ? 'true' : 'false') . '" other_features_enable="' . ($other_features_enable ? 'true' : 'false') . '"]');
            endif;
        }

        /**
         * advanced_property_search
         */
        public function advanced_property_search()
        {
            $enable_advanced_search_form = ere_get_option('enable_advanced_search_form', '1');
            if ($enable_advanced_search_form == '1') {
                $property_price_field_layout = ere_get_option('advanced_search_price_field_layout', '0');
                $property_size_field_layout = ere_get_option('advanced_search_size_field_layout', '0');
                $property_land_field_layout = ere_get_option('advanced_search_land_field_layout', '0');
                echo do_shortcode('[ere_property_advanced_search layout="tab" column="3" color_scheme="color-dark" status_enable="true" type_enable="true" title_enable="true" address_enable="true" country_enable="true" state_enable="true"  city_enable="true"  neighborhood_enable="true" bedrooms_enable="true" bathrooms_enable="true" price_enable="true" price_is_slider="' . (($property_price_field_layout == '1') ? 'true' : 'false') . '" area_enable="true" area_is_slider="' . (($property_size_field_layout == '1') ? 'true' : 'false') . '" land_area_enable="true" land_area_is_slider="' . (($property_land_field_layout == '1') ? 'true' : 'false') . '" label_enable="true" garage_enable="true" property_identity_enable="true" other_features_enable="true"]');
            }
        }

        /**
         * property_sidebar
         */
        public function  sidebar_property()
        {
            ere_get_template('global/sidebar-property.php');
        }

        /**
         *agent_sidebar
         */
        public function sidebar_agent()
        {
            ere_get_template('global/sidebar-agent.php');
        }

        /**
         * invoice_sidebar
         */
        public function sidebar_invoice()
        {
            ere_get_template('global/sidebar-invoice.php');
        }

        /**
         * archive_property_heading
         * @param $total_post
         * @param $taxonomy_title
         * @param $agent_id
         * @param $author_id
         */
        public function archive_property_heading($total_post, $taxonomy_title, $agent_id, $author_id)
        {
            ?>
            <div class="ere-heading">
                <span></span>
                <?php if (is_tax()): ?>
                    <h2><?php echo esc_html($taxonomy_title); ?>
                        <sub>(<?php echo ere_get_format_number($total_post); ?>)</sub></h2>
                <?php elseif (!empty($agent_id) && $agent_id > 0):
                    $agent_name = get_the_title($agent_id);
                    ?>
                    <h2><?php echo esc_html($agent_name); ?>
                        <sub>(<?php echo ere_get_format_number($total_post); ?>)</sub></h2>
                <?php elseif (!empty($author_id) && $author_id > 0):
                    $user_info = get_userdata($author_id);
                    if (empty($user_info->first_name) && empty($user_info->last_name)) {
                        $agent_name = $user_info->user_login;
                    } else {
                        $agent_name = $user_info->first_name . ' ' . $user_info->last_name;
                    }
                    ?>
                    <h2><?php echo esc_html($agent_name); ?>
                        <sub>(<?php echo ere_get_format_number($total_post); ?>)</sub></h2>
                <?php else: ?>
                    <h2><?php esc_html_e('Properties', 'essential-real-estate') ?>
                        <sub>(<?php echo ere_get_format_number($total_post); ?>)</sub></h2>
                <?php endif; ?>
            </div>
            <?php
        }

        /**
         * archive_property_action
         * @param $taxonomy_name
         */
        public function archive_property_action($taxonomy_name)
        {
            $property_archive_link = get_post_type_archive_link('property');
            ?>
            <div class="archive-property-action">
                <?php if ($taxonomy_name != 'property-status'): ?>
                    <div class="archive-property-action-item">
                        <div class="property-status property-filter">
                            <ul>
                                <li class="active"><a data-status="all" href="<?php
                                    $pot_link_status = add_query_arg('status', 'all', $property_archive_link);
                                    echo esc_url($pot_link_status) ?>"
                                                      title="<?php esc_html_e('All', 'essential-real-estate'); ?>"><?php esc_html_e('All', 'essential-real-estate'); ?></a>
                                </li>
                                <?php
                                $property_status = ere_get_property_status_search();
                                if ($property_status) :
                                    foreach ($property_status as $status):?>
                                        <li><a data-status="<?php echo esc_attr($status->slug) ?>" href="<?php
                                            $pot_link_status = add_query_arg('status', $status->slug, $property_archive_link);
                                            echo esc_url($pot_link_status) ?>"
                                               title="<?php echo esc_attr($status->name) ?>"><?php echo esc_html($status->name) ?></a>
                                        </li>
                                    <?php endforeach;
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="archive-property-action-item">
                    <div class="sort-property property-filter">
                        <span
                            class="property-filter-placeholder"><?php esc_html_e('Sort By', 'essential-real-estate'); ?></span>
                        <ul>
                            <li><a data-sortby="default" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'default'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Default Order', 'essential-real-estate'); ?>"><?php esc_html_e('Default Order', 'essential-real-estate'); ?></a>
                            </li>
                            <li><a data-sortby="featured" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'featured'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Featured', 'essential-real-estate'); ?>"><?php esc_html_e('Featured', 'essential-real-estate'); ?></a>
                            </li>
                            <li><a data-sortby="most_viewed" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'most_viewed'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Most Viewed', 'essential-real-estate'); ?>"><?php esc_html_e('Most Viewed', 'essential-real-estate'); ?></a>
                            </li>
                            <li><a data-sortby="a_price" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'a_price'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Price (Low to High)', 'essential-real-estate'); ?>"><?php esc_html_e('Price (Low to High)', 'essential-real-estate'); ?></a>
                            </li>
                            <li><a data-sortby="d_price" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'd_price'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Price (High to Low)', 'essential-real-estate'); ?>"><?php esc_html_e('Price (High to Low)', 'essential-real-estate'); ?></a>
                            </li>
                            <li><a data-sortby="a_date" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'a_date'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Date (Old to New)', 'essential-real-estate'); ?>"><?php esc_html_e('Date (Old to New)', 'essential-real-estate'); ?></a>
                            </li>
                            <li><a data-sortby="d_date" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'd_date'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Date (New to Old)', 'essential-real-estate'); ?>"><?php esc_html_e('Date (New to Old)', 'essential-real-estate'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="view-as" data-admin-url="<?php echo ERE_AJAX_URL; ?>">
						<span data-view-as="property-list" class="view-as-list"
                              title="<?php esc_html_e('View as List', 'essential-real-estate') ?>">
							<i class="fa fa-list-ul"></i>
						</span>
						<span data-view-as="property-grid" class="view-as-grid"
                              title="<?php esc_html_e('View as Grid', 'essential-real-estate') ?>">
							<i class="fa fa-th-large"></i>
						</span>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * archive_agent_heading
         * @param $total_post
         */
        public function archive_agent_heading($total_post)
        {
            ?>
            <div class="ere-heading sm-mg-bottom-40">
                <span></span>

                <h2><?php esc_html_e('Agents', 'essential-real-estate') ?>
                    <sub>(<?php echo ere_get_format_number($total_post); ?>)</sub></h2>
            </div>
            <?php
        }

        /**
         * archive_agent_action
         * @param $keyword
         */
        public function archive_agent_action($keyword)
        {
            ?>
            <div class="archive-agent-action">
                <div class="archive-agent-action-item">
                    <form method="get" action="<?php echo get_post_type_archive_link('agent'); ?>">
                        <div class="form-group input-group search-box"><input type="search" name="agent_name"
                                                                              value="<?php echo esc_attr($keyword); ?>"
                                                                              class="form-control"
                                                                              placeholder="<?php esc_html_e('Search...', 'essential-real-estate'); ?>"> <span
                                class="input-group-btn"><button type="submit" class="button"><i
                                        class="fa fa-search"></i></button> </span>
                        </div>
                    </form>
                </div>
                <div class="archive-agent-action-item">
                    <div class="sort-agent">
                        <span class="sort-by"><?php esc_html_e('Sort By', 'essential-real-estate'); ?></span>
                        <ul>
                            <li><a data-sortby="a_name" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'a_name'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Name (A to Z)', 'essential-real-estate'); ?>"><?php esc_html_e('Name (A to Z)', 'essential-real-estate'); ?></a>
                            </li>
                            <li><a data-sortby="d_name" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'd_name'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Name (Z to A)', 'essential-real-estate'); ?>"><?php esc_html_e('Name (Z to A)', 'essential-real-estate'); ?></a>
                            </li>
                            <li><a data-sortby="a_date" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'a_date'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Date (Old to New)', 'essential-real-estate'); ?>"><?php esc_html_e('Date (Old to New)', 'essential-real-estate'); ?></a>
                            </li>
                            <li><a data-sortby="d_date" href="<?php
                                $pot_link_sortby = add_query_arg(array('sortby' => 'd_date'));
                                echo esc_url($pot_link_sortby) ?>"
                                   title="<?php esc_html_e('Date (New to Old)', 'essential-real-estate'); ?>"><?php esc_html_e('Date (New to Old)', 'essential-real-estate'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="view-as" data-admin-url="<?php echo ERE_AJAX_URL; ?>">
                            <span data-view-as="agent-list" class="view-as-list"
                                  title="<?php esc_html_e('View as List', 'essential-real-estate') ?>">
                                <i class="fa fa-list-ul"></i>
                            </span>
                            <span data-view-as="agent-grid" class="view-as-grid"
                                  title="<?php esc_html_e('View as Grid', 'essential-real-estate') ?>">
                                <i class="fa fa-th-large"></i>
                            </span>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * loop_property
         * @param $property_item_class
         * @param $custom_property_image_size
         */
        public function loop_property($property_item_class, $custom_property_image_size)
        {
            ere_get_template('loop/property.php', array('property_item_class' => $property_item_class, 'custom_property_image_size' => $custom_property_image_size));
        }

        /**
         * loop_agent
         * @param $gf_item_wrap
         * @param $agent_layout_style
         */
        public function loop_agent($gf_item_wrap, $agent_layout_style, $custom_agent_image_size)
        {
            ere_get_template('loop/agent.php', array('gf_item_wrap' => $gf_item_wrap, 'agent_layout_style' => $agent_layout_style, 'custom_agent_image_size' => $custom_agent_image_size));
        }

        /**
         * single_property_header
         */
        public function single_property_header()
        {
            ere_get_template('single-property/header.php');
        }

        /**
         * single_property_footer
         */
        public function single_property_footer()
        {
            ere_get_template('single-property/footer.php');
        }

        /**
         * single_property_reviews
         */
        public function single_property_reviews()
        {
            ere_get_template('single-property/review.php');
        }

        /**
         * single_property_gallery
         */
        public function single_property_gallery()
        {
            ere_get_template('single-property/gallery.php');
        }

        /**
         * single_property_description
         */
        public function single_property_description()
        {
            ere_get_template('single-property/description.php');
        }

        /**
         * single_property_attachments
         */
        public function single_property_attachments()
        {
            ere_get_template('single-property/attachments.php');
        }

        /**
         * single_property_location
         */
        public function single_property_location()
        {
            ere_get_template('single-property/location.php');
        }

        /**
         * single_property_features
         */
        public function single_property_features()
        {
            ere_get_template('single-property/features.php');
        }

        /**
         * single_property_floors
         */
        public function single_property_floors()
        {
            global $post;
            $property_meta_data = get_post_custom($post->ID);
            $property_floors = get_post_meta($post->ID, ERE_METABOX_PREFIX . 'floors', true);
            $property_floor_enable = isset($property_meta_data[ERE_METABOX_PREFIX . 'floors_enable']) ? $property_meta_data[ERE_METABOX_PREFIX . 'floors_enable'][0] : '';
            if ($property_floor_enable && $property_floors) {
                ere_get_template('single-property/floors.php', array('property_floors' => $property_floors));
            }
        }

        /**
         * single_property_map_directions
         */
        public function single_property_map_directions()
        {
            global $post;
            $enable_map_directions = ere_get_option('enable_map_directions', 1);
            if ($enable_map_directions == 1):?>
                <div class="property-directions mg-bottom-60 sm-mg-bottom-40">
                    <div class="ere-heading-style2 mg-bottom-35 text-left">
                        <h2><?php esc_html_e('Get Directions', 'essential-real-estate'); ?></h2>
                    </div>
                    <?php ere_get_template('single-property/google-map-directions.php', array('property_id' => $post->ID)); ?>
                </div>
            <?php endif;
        }

        /**
         * single_property_nearby_places
         */
        public function single_property_nearby_places()
        {
            global $post;
            $enable_nearby_places = ere_get_option('enable_nearby_places', 1);
            if ($enable_nearby_places == 1):?>
                <div class="property-nearby-places mg-bottom-60 sm-mg-bottom-40">
                    <div class="ere-heading-style2 mg-bottom-35 text-left">
                        <h2><?php esc_html_e('Nearby Places', 'essential-real-estate'); ?></h2>
                    </div>
                    <?php ere_get_template('single-property/nearby-places.php', array('property_id' => $post->ID)); ?>
                </div>
            <?php endif;
        }

        /**
         * single_property_walk_score
         */
        public function single_property_walk_score()
        {
            global $post;
            $enable_walk_score = ere_get_option('enable_walk_score', 0);
            if ($enable_walk_score == 1):?>
                <div class="property-walk-score mg-bottom-60 sm-mg-bottom-40">
                    <div class="ere-heading-style2 mg-bottom-35 text-left">
                        <h2><?php esc_html_e('Walk Score', 'essential-real-estate'); ?></h2>
                    </div>
                    <?php ere_get_template('single-property/walk-score.php', array('property_id' => $post->ID)); ?>
                </div>
            <?php endif;
        }

        /**
         * single_property_contact_agent
         */
        public function single_property_contact_agent()
        {
            $property_form_sections = ere_get_option('property_form_sections', array('title_des', 'location', 'type', 'price', 'features', 'details', 'media', 'floors', 'agent'));
            $hide_contact_information_if_not_login = ere_get_option('hide_contact_information_if_not_login', 0);
            if ($hide_contact_information_if_not_login == 0) {
                if (in_array('contact', $property_form_sections)) {
                    ere_get_template('single-property/contact-agent.php');
                }
            } else {
                if (is_user_logged_in()) {
                    if (in_array('contact', $property_form_sections)) {
                        ere_get_template('single-property/contact-agent.php');
                    }
                } else {
                    ?>
                    <p class="ere-account-sign-in"><?php esc_attr_e('Please login or register to view contact information for this agent/owner', 'essential-real-estate'); ?>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#ere_signin_modal">
                            <?php esc_html_e('Login', 'essential-real-estate'); ?>
                        </button>
                    </p>
                    <?php
                }
            }

        }

        /**
         * single_agent_info
         */
        public function single_agent_info()
        {
            ere_get_template('single-agent/agent-info.php');
        }

        /**
         * single_agent_reviews
         */
        public function single_agent_reviews()
        {
            ere_get_template('single-agent/review.php');
        }

        /**
         * single_agent_property
         */
        public function single_agent_property()
        {
            $enable_property_of_agent = ere_get_option('enable_property_of_agent');
            if ($enable_property_of_agent == 1) {
                ere_get_template('single-agent/agent-property.php');
            }
        }

        /**
         * author_info
         */
        public function author_info()
        {
            ere_get_template('author/author-info.php');
        }

        /**
         * author_property
         */
        public function author_property()
        {
            ere_get_template('author/author-property.php');
        }

        /**
         * single_agent_other
         */
        public function single_agent_other()
        {
            $enable_other_agent = ere_get_option('enable_other_agent');
            if ($enable_other_agent == 1) {
                ere_get_template('single-agent/other-agent.php');
            }
        }

        /**
         * single_invoice
         */
        public function single_invoice()
        {
            ere_get_template('single-invoice/invoice.php');
        }

        /**
         * taxonomy_agency_detail
         */
        public function taxonomy_agency_detail()
        {
            ere_get_template('taxonomy/agency-detail.php');
        }

        /**
         * taxonomy_agency_agents
         * @param $agency_term_slug
         */
        public function taxonomy_agency_agents($agency_term_slug)
        {
            ere_get_template('taxonomy/agency-agents.php', array('agency_term_slug' => $agency_term_slug));
        }

        /**
         * Social Share
         */
        public function property_view_gallery()
        {
            ere_get_template('property/view-galley.php');
        }

        /**
         * Favorite
         */
        public function property_favorite()
        {
            if (ere_get_option('enable_favorite_property', '1') == '1') {
                ere_get_template('property/favorite.php');
            }
        }

        /**
         * Compare
         */
        public function property_compare()
        {
            if (ere_get_option('enable_compare_properties', '1') == '1'):?>
                <a class="compare-property" href="javascript:void(0)"
                   data-property-id="<?php the_ID() ?>" data-toggle="tooltip"
                   title="<?php esc_html_e('Compare', 'essential-real-estate') ?>">
                    <i class="fa fa-plus"></i>
                </a>
            <?php endif;
        }

        /**
         * comments_template
         */
        public function comments_template()
        {
            // If comments are open or we have at least one comment, load up the comment template
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
        }
    }
}
if (!function_exists('ere_template_hooks')) {
    function ere_template_hooks()
    {
        return ERE_Template_Hooks::get_instance();
    }
}
// Global for backwards compatibility.
$GLOBALS['ere_template_hooks'] = ere_template_hooks();