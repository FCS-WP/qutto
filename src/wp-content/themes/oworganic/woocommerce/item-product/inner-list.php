<?php 
global $product;
$product_id = $product->get_id();
$image_size = isset($image_size) ? $image_size : '930x595';

?>
<div class="product-block list" data-product-id="<?php echo esc_attr($product_id); ?>">
    <div class="list-inner row no-margin flex-sm">

        <div class="col-xs-12 no-padding col-sm-4 flex">
            <div class="metas flex-middle">
                <div class="clearfix">
                            
                    <?php oworganic_woo_display_product_cat($product_id); ?>

                    <h3 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php
                        /**
                        * woocommerce_after_shop_loop_item_title hook
                        *
                        * @hooked woocommerce_template_loop_rating - 5
                        * @hooked woocommerce_template_loop_price - 10
                        */
                        remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5);
                        do_action( 'woocommerce_after_shop_loop_item_title');
                    ?>

                    <div class="meta-buttons flex-middle">
                        <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

                        <?php if (oworganic_get_config('show_quickview', false)) { ?>
                            <div class="view">
                                <a href="javascript:void(0);" class="quickview" data-product_id="<?php echo esc_attr($product_id); ?>">
                                    <i class="ti-eye"></i>
                                </a>
                            </div>
                        <?php } ?>

                        <?php
                            if ( class_exists( 'YITH_WCWL' ) ) {
                                echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
                            } elseif ( oworganic_is_woosw_activated() && get_option('woosw_button_position_archive') == "0" ) {
                                echo do_shortcode('[woosw]');
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 no-padding col-sm-8">
            <div class="block-inner">
                <figure class="image">
                    <?php
                        oworganic_product_image($image_size);
                        do_action( 'woocommerce_before_shop_loop_item_title' );
                    ?>
                </figure>
                
            </div>
        </div>
        
    </div>
</div>