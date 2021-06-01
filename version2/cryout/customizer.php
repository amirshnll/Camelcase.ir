<?php
function cryout_customizer_sanitize_blank(){
}
function cryout_customizer_sanitize_number($input){
	return ( is_numeric( $input ) ) ? $input : intval( $input );
}
function cryout_customizer_sanitize_checkbox($input){
    if ( intval( $input ) == 1 ) return 1;
    return 0;
}
function cryout_customizer_sanitize_url($input){
	return esc_url_raw( $input );
}
function cryout_customizer_sanitize_googlefont($input){
	return preg_replace( '/\+/', ' ', wp_kses_post($input) );
}
function cryout_customizer_sanitize_color($input){
	return sanitize_hex_color($input);
}
function cryout_customizer_sanitize_text($input){
	return wp_kses_post( $input );
}
function cryout_customizer_sanitize_generic($input){
	return wp_kses_post( $input );
}
class Cryout_Customizer {
	public function __construct () {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	public static function register( $wp_customize ) {
		global $cryout_theme_settings;
		global $cryout_theme_defaults;
		$wp_customize->register_section_type( 'Cryout_Customize_About_Section' );
		if (!empty($cryout_theme_settings['info_sections'])):
			$section_priority = 10;
			foreach ($cryout_theme_settings['info_sections'] as $iid=>$info):
				$wp_customize->add_section( new Cryout_Customize_About_Section( $wp_customize, $iid, array(
					'title'          => $info['title'],
					'description'    => $info['desc'],
					'priority'       => $section_priority++,
					'button'		 => $info['button'],
					'button_label'	 => $info['button_label'],
				) ) );
			endforeach;
		endif;
		foreach ($cryout_theme_settings['info_settings'] as $iid => $info):
			$wp_customize->add_setting( $iid, array(
				'default'        => $info['default'],
				'capability'     => 'edit_theme_options',
				'sanitize_callback' => 'cryout_customizer_sanitize_blank'
			) );
			$wp_customize->add_control( new Cryout_Customize_About_Control( $wp_customize, $iid, array(
				'label'   	 => $info['label'],
				'description' => $info['desc'],
				'section' 	 => $info['section'],
				'default' 	 => $info['default'],
				'settings'   => $iid,
				'priority'   => 10,
			) ) );
		endforeach;
		$priority = 45;
		foreach ($cryout_theme_settings['panels'] as $panel):
			$identifier = ( !empty($panel['identifier'])? $panel['identifier'] : 'cryout-' );
			$wp_customize->add_panel( $identifier . $panel['id'], array(
			  'title' => $panel['title'],
			  'description' => '',
			  'priority' => $priority+=5,
			) );
		endforeach;
		$section_priority = 60;
		foreach ($cryout_theme_settings['sections'] as $section):
			$wp_customize->add_section( 'cryout-' . $section['id'], array(
				'title'          => $section['title'],
				'description'    => '',
				'priority'       => ( isset($section['priority']) ? $section['priority'] : $section_priority+=5 ),
				'panel'  		 => ( !empty($section['sid']) ? 'cryout-' . $section['sid'] : '' ),
			) );
		endforeach;
		if (!empty($cryout_theme_settings['panel_overrides']))
		foreach ($cryout_theme_settings['panel_overrides'] as $poid => $pover):
			if (empty($pover['priority2'])) $pover['priority2'] = 60;
			switch ($pover['type']):
				case 'remove':
					switch( $pover['section'] ):
						case 'panel':
							$wp_customize->remove_panel( $pover['replaces']);
							break;
						case 'section':
							$wp_customize->remove_section( $pover['replaces']);
							break;
						case 'setting':
						default:
							$wp_customize->remove_setting( $pover['replaces']);
							break;
					endswitch;
					break;
				case 'section':
					$wp_customize->get_section( $pover['replaces'] )->panel = $pover['section'];
					$wp_customize->get_section( $pover['replaces'] )->priority = $pover['priority2'];
					break;
				case 'panel':
				default:
					$wp_customize->add_panel( 'cryout-' . $poid, array(
						'priority'       => $pover['priority'],
						'title'          => $pover['title'],
						'description'    => $pover['desc'],
					) );
					$wp_customize->get_section( $pover['replaces'] )->panel = 'cryout-' . $poid;
					$wp_customize->get_section( $pover['replaces'] )->priority = $pover['priority2'];
					break;
			endswitch;
		endforeach;
		$priority = 10;
		foreach ($cryout_theme_settings['options'] as $opt):
			if ( !empty( $opt['disable_if'] ) ) {
				if ( function_exists($opt['disable_if']) ) continue;
			}
			if ( !empty( $opt['require_fn'] ) ) {
				if ( ! function_exists($opt['require_fn']) ) continue;
			}
			$clone_count = 1;
			if (preg_match('/#/',$opt['id'])) {
				$clone_section_id = str_replace( '#', '', $opt['section'] );
				if (!empty($cryout_theme_settings['clones'][$clone_section_id]))
					$clone_count = $cryout_theme_settings['clones'][$clone_section_id];

			}
			switch ($opt['type']):
				case 'number': case 'slider': case 'numberslider':
				case 'range':			$sanitize_callback = 'cryout_customizer_sanitize_number'; 		break;
				case 'checkbox':
				case 'toggle':			$sanitize_callback = 'cryout_customizer_sanitize_checkbox';		break;
				case 'url': 			$sanitize_callback = 'cryout_customizer_sanitize_url';			break;
				case 'color':			$sanitize_callback = 'cryout_customizer_sanitize_color';		break;
				case 'googlefont':      $sanitize_callback = 'cryout_customizer_sanitize_googlefont';   break;
				case 'media': case 'media-image':
										$sanitize_callback = 'cryout_customizer_sanitize_number';		break;
				case 'hint': case 'blank':
										$sanitize_callback = 'cryout_customizer_sanitize_blank';		break;
				case 'text': case 'tel': case 'email': case 'search':  case 'radio':
				case 'time': case 'date': case 'datetime': case 'week':
				case 'textarea':		$sanitize_callback = 'cryout_customizer_sanitize_text';			break;
				default: 				$sanitize_callback = 'cryout_customizer_sanitize_generic';		break;
			endswitch;
			$sanitize_callback = apply_filters( 'cryout_customizer_custom_control_sanitize_callback', $sanitize_callback, $opt['id'] );
			$_opt_id = $opt['id'];
			$_opt_section = $opt['section'];
			for ( $i=1; $i<=$clone_count; $i++ ) {
				$opt['id'] = str_replace( '#', $i, $_opt_id );
				$opt['section'] = str_replace( '#', $i, $_opt_section );
				if (function_exists('cryout_get_theme_options_name')) {
					$theme_options_array = cryout_get_theme_options_name();
				} else {
					$theme_options_array = _CRYOUT_THEME_NAME . '_settings';
				};
				$opid = $theme_options_array . '[' . $opt['id'] . ']';
				if ( empty($opt['addon']) || $opt['addon'] != TRUE )
					$opt['section'] = 'cryout-' . $opt['section'];
				$wp_customize->add_setting( $opid, array(
					'type'			=> 'option',
					'default'       => ( isset( $cryout_theme_defaults[$opt['id']] ) ? $cryout_theme_defaults[$opt['id']] : '' ),
					'capability'    => 'edit_theme_options',
					'sanitize_callback' => $sanitize_callback,
					'transport' 	=> (isset($opt['transport'])?$opt['transport']:'refresh'),
				) );
				switch ($opt['type']):
					case 'text':
					case 'number':
					case 'url': case 'tel': case 'email': case 'search:': case 'time': case 'date': case 'datetime': case 'week':
					case 'textarea':
					case 'checkbox':
						$wp_customize->add_control( $opid, array(
							'label'		=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'input_attrs' => (!empty($opt['input_attrs'])?$opt['input_attrs']:array()),
							'type'		=> $opt['type'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) );
						break;
					case 'toggle':
						$wp_customize->add_control( new Cryout_Customize_Toggle_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'input_attrs'	=> (isset($opt['disabled'])?array('disabled'=>$opt['disabled']):array('disabled'=>false)),
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'choices'	=> (isset($opt['choices'])?$opt['choices']:$opt['values']),
							'disabled'	=> (isset($opt['disabled'])?$opt['disabled']:''),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'googlefont':
						$wp_customize->add_control( $opid, array(
							'label'		=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'input_attrs' => (!empty($opt['input_attrs'])?$opt['input_attrs']:array()),
							'type'		=> 'text',
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) );
						break;
					case 'radio':
					case 'select':
						if (empty($opt['choices']) && empty($opt['labels'])) $opt['labels'] = $opt['values'];
						$wp_customize->add_control( $opid, array(
							'label'		=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'type'		=> $opt['type'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'choices'	=> (isset($opt['choices'])?$opt['choices']:array_combine($opt['values'],$opt['labels'])),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) );
						break;
					case 'selecthalf':
					case 'selectthird':
						if (empty($opt['choices']) && empty($opt['labels'])) $opt['labels'] = $opt['values'];
						$wp_customize->add_control(  new Cryout_Customize_SelectShort_Control( $wp_customize, $opid, array(
							'label'		=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'type'		=> $opt['type'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'choices'	=> (isset($opt['choices'])?$opt['choices']:array_combine($opt['values'],$opt['labels'])),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'select2':
						$wp_customize->add_control( new Cryout_Customize_Select2_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'input_attrs'	=> (isset($opt['disabled'])?array('disabled'=>$opt['disabled']):array('disabled'=>false)),
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'choices'	=> (isset($opt['choices'])?$opt['choices']:array_combine($opt['values'],$opt['labels'])),
							'disabled'	=> (isset($opt['disabled'])?$opt['disabled']:''),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'optselect':
						$wp_customize->add_control( new Cryout_Customize_OptSelect_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'input_attrs'	=> (isset($opt['disabled'])?array('disabled'=>$opt['disabled']):array('disabled'=>false)),
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'choices'	=> (isset($opt['choices'])?$opt['choices']:array_combine($opt['values'],$opt['labels'])),
							'disabled'	=> (isset($opt['disabled'])?$opt['disabled']:''),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'range':
						$wp_customize->add_control( $opid, array(
							'label'		=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'type'		=> $opt['type'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'input_attrs' => array( 'min' => $opt['min'], 'max' => $opt['max'], 'step' => (isset($opt['step'])?$opt['step']:10) ),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) );
						break;
					case 'slider':
						$wp_customize->add_control(  new Cryout_Customize_Slider_Control( $wp_customize, $opid, array(
							'label'		=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'type'		=> $opt['type'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'input_attrs' => array(
										'min' => $opt['min'],
										'max' => $opt['max'],
										'step' => (isset($opt['step'])?$opt['step']:10),
										'um' => (isset($opt['um'])?$opt['um']:'')
										),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'slidertwo':
						$wp_customize->add_control(  new Cryout_Customize_SliderTwo_Control( $wp_customize, $opid, array(
							'label'		=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'type'		=> $opt['type'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'input_attrs' => array(
										'min' => $opt['min'],
										'max' => $opt['max'],
										'step' => (isset($opt['step'])?$opt['step']:10),
										'total' => (isset($opt['total'])?$opt['total']:0),
										'um' => (isset($opt['um'])?$opt['um']:'')
										),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'numberslider':
					case 'slidernumber':
						$wp_customize->add_control(  new Cryout_Customize_NumberSlider_Control( $wp_customize, $opid, array(
							'label'		=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'type'		=> $opt['type'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'input_attrs' => array(
										'min' => $opt['min'],
										'max' => $opt['max'],
										'step' => (isset($opt['step'])?$opt['step']:10),
										'um' => (isset($opt['um'])?$opt['um']:''),
										'readonly' => (isset($opt['readonly'])?$opt['readonly']:'')
										),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'radioimage':
						$wp_customize->add_control( new Cryout_Customize_RadioImage_Control( $wp_customize, $opid, array(
							'label'		=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'type'		=> $opt['type'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'choices' 	=> (isset($opt['choices'])?$opt['choices']:array_combine($opt['values'],$opt['labels'])),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'sortable':
						if (class_exists('Cryout_Customize_Sortable_Control')) {
							$wp_customize->add_control( new Cryout_Customize_Sortable_Control( $wp_customize, $opid, array(
								'label'		=> $opt['label'],
								'description'	=> (isset($opt['desc'])?$opt['desc']:''),
								'section'	=> $opt['section'],
								'settings'	=> $opid,
								'type'		=> $opt['type'],
								'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
								'choices' 	=> (isset($opt['choices'])?$opt['choices']:array_combine($opt['values'],$opt['labels'])),
								'input_attrs' => (!empty($opt['input_attrs'])?$opt['input_attrs']:array()),
								'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
							) ) );
						}
						break;
					case 'color':
						$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'font':
						$wp_customize->add_control( new Cryout_Customize_Font_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'input_attrs' => array(
									'no_inherit' => (isset($opt['no_inherit'])?$opt['no_inherit']:FALSE),
							),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'iconselect':
						$wp_customize->add_control( new Cryout_Customize_IconSelect_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'media-image':
						$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'mime_type'	=> 'image',
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'media':
						$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'description':
						$wp_customize->add_control( new Cryout_Customize_Description_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> $opt['desc'],
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'input_attrs' => (!empty($opt['input_attrs'])?$opt['input_attrs']:array()),
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'hint':
						$wp_customize->add_control( new Cryout_Customize_Hint_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> $opt['desc'],
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'input_attrs' => (!empty($opt['input_attrs'])?$opt['input_attrs']:array()),
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'notice':
						$wp_customize->add_control( new Cryout_Customize_Notice_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> $opt['desc'],
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'input_attrs' => (!empty($opt['input_attrs'])?$opt['input_attrs']:array()),
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
					case 'spacer':
						$wp_customize->add_control( new Cryout_Customize_Spacer_Control( $wp_customize, $opid, array(
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
						) ) );
						break;
					case NULL:
						$wp_customize->add_control( new Cryout_Customize_Null_Control( $wp_customize, $opid ) );
						break;
					case 'blank':
					default:
						$wp_customize->add_control( new Cryout_Customize_Blank_Control( $wp_customize, $opid, array(
							'label' 	=> $opt['label'],
							'description'	=> (isset($opt['desc'])?$opt['desc']:''),
							'section'	=> $opt['section'],
							'settings'	=> $opid,
							'priority'	=> (isset($opt['priority'])?$opt['priority']:$priority),
							'active_callback' => ( (isset($opt['active_callback'])) ? $opt['active_callback'] : NULL),
						) ) );
						break;
				endswitch;
			}
		endforeach;
	}
}
function cryout_customizer_enqueue_scripts() {
	wp_enqueue_style( 'cryout-customizer-css', get_template_directory_uri() . '/cryout/css/customizer.css', array(), _CRYOUT_FRAMEWORK_VERSION );
	wp_add_inline_style( 'cryout-customizer-css', cryout_customize_theme_identification() ); // function located in includes/custom-styles.php
	wp_enqueue_script( 'cryout-customizer-js', get_template_directory_uri() . '/cryout/js/customizer.js', array( 'jquery' ), _CRYOUT_FRAMEWORK_VERSION, true );
}
add_action('customize_controls_enqueue_scripts', 'cryout_customizer_enqueue_scripts');
?>