<?php
/**
 * The template for displaying all single products
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<article class="page type-page hentry">
				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); 
					$product_price = get_post_meta( get_the_ID(), 'price', true);
					$product_masp = get_post_meta( get_the_ID(), 'product_code', true);
					$product_type = get_post_meta( get_the_ID(), 'material', true);
	          		$product_thumbnail = wp_get_attachment_url( get_post_meta( get_the_ID(), 'image', true) );
	                if (empty($product_thumbnail)) {
	                    $product_thumbnail = get_stylesheet_directory_uri() . '/images/no_image.png';
	                }

				?>	
					
					<div class="entry-content product-detail">
						<div class="product-des">
							<h2 class="entry-title"><?php the_title() ?></h2>
							<p><span><b>Mã sản phẩm:</b> </span><span><?php echo $product_masp; ?></span></p>
							<p><span><b>Chất liệu:</b> </span><span><?php echo $product_type; ?></span></p>
							<p><span><b>Xuất xứ:</b> </span><span><?php echo $product_price; ?></span></p>
						</div>
						<div class="product-img">
							<img src="<?php echo esc_url( $product_thumbnail ); ?>" class="">
						</div>
						<div class="clear"></div>
						<div class="product-body">
							<h3>Thông tin sản phẩm</h3>
							<?php the_content() ?>
						</div>
						<?php //get_template_part( 'content', get_post_format() ); ?>
						<?php //twentythirteen_post_nav(); ?>
						<?php //comments_template(); ?>
					</div>

				<?php endwhile; ?>
			</article>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>