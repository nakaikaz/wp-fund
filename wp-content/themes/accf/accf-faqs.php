<?php
/*
Template Name: よくあるご質問ページ
*/
get_header();
?>

		<div class="container_12">

			<?php get_sidebar(); ?>

			<div id="content" class="grid_8">
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header>
						<h2><?php the_title(); ?></h2>
					</header>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<footer>
						<p></p>
					</footer>

				</article><!-- #post -->

			<?php endwhile; // end of the loop. ?>
			</div>
			<div style="clear: both;"></div>
		</div>
<?php get_footer(); ?>