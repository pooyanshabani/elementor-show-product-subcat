<?php

class Elementor_Psh_Product_Widget_IMG extends \Elementor\Widget_Base {

    public function get_name() {
        return 'psh_product_cat_img';
    }

    public function get_title() {
        return 'تصویر دسته بندی محصول';
    }

    public function get_icon() {
        return 'eicon-featured-image';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function register_controls() {

		$this->start_controls_section(
			'content_section_img',
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
			'Psh_Product_list_img',
				[
					'label' => 'انتخاب دسته بندی',
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => $options,	
				]	
		);

        $this->add_control(
			'product_cat_img_align',
				[
					'label' => 'جهت',
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'left',
					'options' => [
						'left' => esc_html__( 'Default', 'textdomain' ),
						'right' => esc_html__( 'Right', 'textdomain' ),
						'center'  => esc_html__( 'Center', 'textdomain' ),
					],	
				]	
		);


		$this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $product_cat_img_id = $settings['Psh_Product_list_img'];
        $product_cat_img_align = $settings['product_cat_img_align'];
        //$product_grid_cgap = $settings['Psh_Product_Grid_Cgap'];
        //$product_grid_rgap = $settings['Psh_Product_Grid_Rgap'];
		$thumbnail_id = get_woocommerce_term_meta( $product_cat_img_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );

        ?>
		<div style="text-align:<?php echo $product_cat_img_align; ?>;">
        	<img src="<?php echo $image; ?>">
		</div>
        <?php
    }

    protected function _content_template() {}

}

