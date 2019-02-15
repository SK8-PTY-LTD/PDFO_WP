<?php
return array(
	'name'     => esc_html__('Pricing', 'g5-beyot'),
	'base'     => 'g5plus_pricing',
	'icon'     => 'fa fa-usd',
	'category' => GF_SHORTCODE_CATEGORY,
	'params'   => array_merge(
		array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Layout Style', 'g5-beyot'),
				'param_name'  => 'name_style',
				'value'       => array(
					esc_html__('Circle Price', 'g5-beyot')     => 'pr_circle_price',
					esc_html__('Background Price', 'g5-beyot') => 'pr_bgr',
				),
				'admin_label' => true,
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Price', 'g5-beyot'),
				'param_name'  => 'price',
				'admin_label' => true,
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Name', 'g5-beyot'),
				'param_name'  => 'name',
				'admin_label' => true,
			),
			array(
				'type'       => 'param_group',
				'heading'    => esc_html__('Pricing Tables', 'g5-beyot'),
				'param_name' => 'values',
				'value'      => urlencode(json_encode(array(
					array(
						'label' => esc_html__('Feature', 'g5-beyot'),
						'value' => '',
					),
				))),
				'params'     => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Feature Text', 'g5-beyot'),
						'param_name'  => 'features',
						'value'       => '',
						'admin_label' => true,
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Feature Value', 'g5-beyot'),
						'param_name'  => 'value',
						'value'       => '',
						'admin_label' => true,
					),
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Button Text', 'g5-beyot'),
				'param_name' => 'title',
			),
			array(
				'type'        => 'vc_link',
				'heading'     => esc_html__('URL (Link)', 'g5-beyot'),
				'param_name'  => 'link',
				'description' => esc_html__('Add link to button.', 'g5-beyot'),
			),
			array(
				'type'             => 'checkbox',
				'heading'          => esc_html__('Featured ?', 'g5-beyot'),
				'param_name'       => 'featured',
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			gf_vc_map_add_extra_class(),
			gf_vc_map_add_css_editor()
		),
		gf_vc_map_animation()
	)
);
