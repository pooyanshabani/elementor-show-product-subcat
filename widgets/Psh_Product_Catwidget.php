<?php

class Elementor_Psh_Product_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'psh_product_cat';
    }

    public function get_title() {
        return 'زیر دسته های محصولات';
    }

    public function get_icon() {
        return 'eicon-table-of-contents';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => 'دسته محصولات',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$categories = get_terms( ['taxonomy' => 'product_cat', 'hide_empty' => false] );
		$options = [];

			foreach ($categories as $category) {
				$options[$category->term_id] = $category->name;
			}
        $this->add_control(
			'Psh_Product_list',
				[
					'label' => 'انتخاب دسته بندی مادر',
					'type' => \Elementor\Controls_Manager::SELECT,	
					'default' => 'solid',
					'options' => $options,	
				]	
		);

		$this->add_control(
			'Psh_icon',
			[
				'label' => esc_html__( 'Icon', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-angel-left',
					'library' => 'fa-solid',
				],
			]
		);


        $this->add_control(
			'Psh_Product_Grid',
				[
					'label' => 'تعداد ستون',
					'type' => \Elementor\Controls_Manager::NUMBER,	
					'default' => 1,
					'min' => 1,
					'max' => 10,
					'step' => 1,
				]	
		);
        $this->add_control(
			'Psh_Product_Grid_Cgap',
				[
					'label' => 'فاصله بین ستون',
					'type' => \Elementor\Controls_Manager::NUMBER,	
					'default' => 10,
					'min' => 1,
					'step' => 0.5,
				]	
		);
        $this->add_control(
			'Psh_Product_Grid_Rgap',
				[
					'label' => 'فاصله بین سطر',
					'type' => \Elementor\Controls_Manager::NUMBER,	
					'default' => 5,
					'min' => 1,
					'step' => 0.5,
				]	
		);

		$this->end_controls_section();

		$this->start_controls_section(
        	'style_section_swithcher',
        	[
				'label' => 'تنظیمات عنوان ',
        		'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        	]
        );	 


		$this->add_control(
			'psh_main_text_color',
			[
				'label' => 'رنگ عنوان',
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-icon-list-icon' => 'fill: {{VALUE}}',
				],			
				'default' => '#848484'
			]
		);

		$this->add_control(
			'psh_hover_mode_text_color',
			[
				'label' => 'رنگ هاور عنوان',
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-text:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-icon-list-icon:hover' => 'fill: {{VALUE}}',
				],			
				'default' => '#04c3c4'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'psh_main_text_type',
				'label' => 'تایپوگرافی',
				'selector' => '{{WRAPPER}} .elementor-icon-list-text',
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => 'انیمیشن هاور',
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
			]
		);


    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $product_cat_id = $settings['Psh_Product_list'];
        $product_grid_col = $settings['Psh_Product_Grid'];
        $product_grid_cgap = $settings['Psh_Product_Grid_Cgap'];
        $product_grid_rgap = $settings['Psh_Product_Grid_Rgap'];

		$elementClass = 'psh-title-container';
		if ( $settings['hover_animation'] ) {
			$elementClass .= ' elementor-animation-' . $settings['hover_animation'];
		}
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );

        ?>
      		<ul class="sub-sub-menu" style="display: grid; grid-template-columns: repeat(<?php echo $product_grid_col;?>, 1fr); grid-column-gap: <?php echo $product_grid_cgap;?>px; grid-row-gap: <?php echo $product_grid_rgap;?>px;">
			<?php
				$categories = get_terms( ['taxonomy' => 'product_cat', 'hide_empty' => false , 'parent' => $product_cat_id ] );
				foreach($categories as $category) { ?>

				<li class="elementor-icon-list-item psh-product-list-wrapper">
					<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
					<a href="<?php echo get_category_link( $category->term_id ); ?>">
						<span class="elementor-icon-list-icon psh-my-icon-wrapper"><?php \Elementor\Icons_Manager::render_icon( $settings['Psh_icon'], [ 'aria-hidden' => 'true' ] ); echo '</span><span class="elementor-icon-list-text"> ' . $category->name; ?></span> 
					</a>
					</div>
				</li>


				<?php }
			?>
			</ul>
	
        <?php
    }

    protected function _content_template() {}

}

