<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Oworganic_Elementor_Banner extends Widget_Base {

	public function get_name() {
        return 'apus_element_banner';
    }

	public function get_title() {
        return esc_html__( 'Apus Banner', 'oworganic' );
    }
    
	public function get_categories() {
        return [ 'oworganic-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Banner', 'oworganic' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'oworganic' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .content-banner' => 'height: {{SIZE}}{{UNIT}};',
                ],

                'condition' => [
                    'style!' => 'style3',
                ],
            ]
        );

        $this->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Image Top', 'oworganic' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Background Image', 'oworganic' ),
                'condition' => [
                    'style' => 'style3',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'oworganic' ),
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => esc_html__( 'Sub Title', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your Sub title here', 'oworganic' ),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'oworganic' ),
                'type' => Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__( 'Enter your description here', 'oworganic' ),
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Button Text', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your button text here', 'oworganic' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'URL', 'oworganic' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your Button Link here', 'oworganic' ),
            ]
        );

        $this->add_responsive_control(
            'banner_align',
            [
                'label' => esc_html__( 'Alignment', 'oworganic' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'oworganic' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'oworganic' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'oworganic' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'oworganic' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wrapper-banner' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'oworganic' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'oworganic'),
                    'style2' => esc_html__('Style 2', 'oworganic'),
                    'style3' => esc_html__('Style 3', 'oworganic'),
                    'style4' => esc_html__('Style 4', 'oworganic'),
                    'style5' => esc_html__('Style 5', 'oworganic'),
                    'style6' => esc_html__('Style 6', 'oworganic'),
                    'style7' => esc_html__('Style 7', 'oworganic'),
                ),
                'default' => 'style1'
            ]
        );
   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'oworganic' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'oworganic' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_box',
            [
                'label' => esc_html__( 'Box', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => esc_html__( 'Background', 'oworganic' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .content-banner',
            ]
        );

        $this->add_responsive_control(
            'padding-box',
            [
                'label' => esc_html__( 'Padding', 'oworganic' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'oworganic' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wrapper-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__( 'Title', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'title_color',
                [
                    'label' => esc_html__( 'Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .title ' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'title_hover_color',
                [
                    'label' => esc_html__( 'Hover Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .wrapper-banner:hover .title ' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'label' => esc_html__( 'Typography', 'oworganic' ),
                    'name' => 'title_typography',
                    'selector' => '{{WRAPPER}} .title',
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_sub_title',
            [
                'label' => esc_html__( 'Sub Title', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'sub_title_color',
                [
                    'label' => esc_html__( 'Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .sub-title ' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'sub_title_hover_color',
                [
                    'label' => esc_html__( 'Hover Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .wrapper-banner:hover .sub-title ' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'label' => esc_html__( 'Typography', 'oworganic' ),
                    'name' => 'sub_title_typography',
                    'selector' => '{{WRAPPER}} .sub-title',
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_description',
            [
                'label' => esc_html__( 'Description', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'description_color',
                [
                    'label' => esc_html__( 'Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .description ' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'description_hover_color',
                [
                    'label' => esc_html__( 'Hover Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .wrapper-banner:hover .description ' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'label' => esc_html__( 'Typography', 'oworganic' ),
                    'name' => 'description_typography',
                    'selector' => '{{WRAPPER}} .description',
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button',
            [
                'label' => esc_html__( 'Button', 'oworganic' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'button_color',
                [
                    'label' => esc_html__( 'Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .btn-banner ' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'button_hover_color',
                [
                    'label' => esc_html__( 'Hover Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .wrapper-banner:hover .btn-banner ' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'button_line_color',
                [
                    'label' => esc_html__( 'Line Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .wrapper-banner .btn-banner::before ' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'button_line_hover_color',
                [
                    'label' => esc_html__( 'Line Hover Color', 'oworganic' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .wrapper-banner:hover .btn-banner::before ' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'label' => esc_html__( 'Typography', 'oworganic' ),
                    'name' => 'button_typography',
                    'selector' => '{{WRAPPER}} .btn-banner',
                ]
            );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-banner <?php echo esc_attr($el_class); ?>">
            <?php if ( !empty($link) ) { ?>
                <a href="<?php echo esc_url($link); ?>">
            <?php } ?>
                <div class="wrapper-banner <?php echo esc_attr($style); ?>">
                    <?php if($style == 'style4') {?>
                        <?php if ( $sub_title ) { ?>
                            <div class="sub-title"><?php echo trim($sub_title); ?></div>
                        <?php } ?>
                    <?php } ?>
                    <div class="content-banner">
                    </div>
                    <div class="inner">

                        <?php
                        if ( !empty($img_src['id']) ) {
                        ?>
                            <div class="img-banner">
                                <?php echo oworganic_get_attachment_thumbnail($img_src['id'], 'full'); ?>
                            </div>
                        <?php } ?>

                        <?php if($style != 'style4') {?>
                            <?php if ( $sub_title ) { ?>
                                <div class="sub-title"><?php echo trim($sub_title); ?></div>
                            <?php } ?>
                        <?php } ?>

                        <?php if ( $title ) { ?>
                            <h2 class="title"><span><?php echo trim($title); ?></span></h2>
                        <?php } ?>

                        <?php if ( !empty($description) ) { ?>
                            <div class="description">
                                <?php echo trim( $description ); ?>
                            </div>
                        <?php } ?>

                        <?php if ( !empty($btn_text) ) { ?>
                            <span class="btn-banner"><?php echo trim($btn_text); ?></span>
                        <?php } ?>
                        
                    </div>
                </div>

            <?php if ( !empty($link) ) { ?>
                </a>
            <?php } ?>
        </div>
        <?php
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Oworganic_Elementor_Banner );
} else {
    Plugin::instance()->widgets_manager->register( new Oworganic_Elementor_Banner );
}