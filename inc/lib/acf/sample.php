<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Advanced Custom Fields meta data i18n extract
 *
 * @package iPress\Config
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// phpcs:disable

//----------------------------------------------
// ACF Meta Data: Sample Section
// - Create in ACF UI and export
// - Replace translation strings if needed
//----------------------------------------------

// Meta: Brands Section
acf_add_local_field_group( 
	[
		'key' 		=> 'group_5bc5f1b677e2e',
		'title' 	=> __('Sample Section', 'ipress-standalone'),
		'fields' 	=> [
			[
				'key' 	=> 'field_5bc5f906d3269',
				'label' => __('Sample Label', 'ipress-standalone'),
				'name' 	=> 'sample_label',
				'type' 	=> 'text',
				'instructions' 		=> '',
				'required' 			=> 1,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' 	=> '',
				],
				'default_value' => '',
				'placeholder' 	=> '',
				'prepend' 		=> '',
				'append' 		=> '',
				'maxlength' 	=> '',
			],
		],
		'location' => [
			[
				[
					'param' 	=> 'options_page',
					'operator' 	=> '==',
					'value' 	=> 'ipress-standalone',
				],
			],
		],
		'menu_order' 			=> 0,
		'position' 				=> 'normal',
		'style' 				=> 'default',
		'label_placement' 		=> 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' 		=> '',
		'active' 				=> true,
		'description' 			=> '',
	]
);
