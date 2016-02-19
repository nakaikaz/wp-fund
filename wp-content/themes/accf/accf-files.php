<?php
/*
Template Name: 資料一覧ページ
*/
get_header();
?>

		<div class="container_12">

			<?php get_sidebar(); ?>

			<div id="content" class="grid_8">
				<div class="entry">
					<h2><?php the_title( ); ?></h2>
					<div class="entries">
						<p></p>
						<div class="clear">&nbsp;</div>
					</div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
<?php get_footer(); ?>