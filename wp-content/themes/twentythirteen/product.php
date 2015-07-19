<?php
/*
Template Name: Product
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content page type-page hentry" role="main">
			<article>
				<header class="entry-header">
					<h1 class="entry-title">Phụ Tùng</h1>
				</header>
				<div class="entry-content">
					
					<ul class="home-products">
		                <?php
			                $args = array(
			                	'post_type' => 'product'
			                );
			                $products = new WP_Query( $args );
			                if( $products->have_posts() ) :
			                	$products_count = 0;
			                    while($products->have_posts() && $products_count < 20) :
			                    	$products->the_post();
		                      		$products_count++;
		                      		$product_price = get_post_meta( get_the_ID(), 'price', true);
		                      		$product_thumbnail = wp_get_attachment_url( get_post_meta( get_the_ID(), 'image', true) );
				                    if (empty($product_thumbnail)) {
				                        $product_thumbnail = get_stylesheet_directory_uri() . '/images/no_image.png';
				                    }
		              	?>
		              				<li class="product-release-container">
			                        	<a class="wrap-feature-img" href="<?php the_permalink(); ?>" class="product-image">
				                            <img width="250" height="150" src="<?php echo esc_url( $product_thumbnail ); ?>" class="">
				                        </a>
			                          <div class="placard-content">
			                            <!-- Title and Meta -->  
			                            <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
			                            <span><b>Price:</b> <?php echo $product_price; ?> VND</span>                           
			                          </div>
			                        </li>
		              	<?php
			                    endwhile;
			                endif;

		                ?>
		                <div class="clear"></div>
		            </ul>

	            </div>

             </article>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>