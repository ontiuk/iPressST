<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Advanced Custom Fields meta data i18n extract
 * 
 * @package		iPress\Config
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	ACF Meta Data: Sample Section
//	- Create in ACF UI and export
//	- Replace translation strings if needed
//----------------------------------------------

// Meta: Brands Section
acf_add_local_field_group( array(
	'key' 		=> 'group_5bc5f1b677e2e',
	'title' 	=> __('Sample Section', 'ipress'),
	'fields' 	=> array(
		array(
			'key' 	=> 'field_5bc5f906d3269',
			'label' => __('Sample Label', 'ipress'),
			'name' 	=> 'sample_label',
			'type' 	=> 'text',
			'instructions' 		=> '',
			'required' 			=> 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' 	=> '',
			),
			'default_value' => '',
			'placeholder' 	=> '',
			'prepend' 		=> '',
			'append' 		=> '',
			'maxlength' 	=> '',
		),
	),
	'location' => array(
		array(
			array(
				'param' 	=> 'options_page',
				'operator' 	=> '==',
				'value' 	=> 'ipress-sample',
			),
		),
	),
	'menu_order' 			=> 0,
	'position' 				=> 'normal',
	'style' 				=> 'default',
	'label_placement' 		=> 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' 		=> '',
	'active' 				=> true,
	'description' 			=> '',
));

// end
