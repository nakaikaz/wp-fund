<?php
/*
Template Name: 事業ページ
*/
global $accf;
get_header();
?>

		<div class="container_12">

			<?php get_sidebar(); ?>

			<div id="content" class="grid_8">

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h2 class="entry-title"><?php the_title(); ?></h2>
					</header>
					<div class="entry-content">

						<div class="box">
							<h3><?php _e( 'Grants', 'accf' ); ?></h3>
							<p><?php _e( 'We manage funds composed of donations from individuals and businesses and disburse grants to nonprofit organizations.', 'accf' ); ?></p>
							<p><a href="<?php echo $accf['home_url']; ?>/programs/grants"><?php _e( 'Read more', 'accf' ); ?></a></p>
							<div class="vertical_dot">
								<div class="grid_4 themefunds">
									<h4><?php _e( 'Designated Fund', 'accf' ); ?></h4>
									<ul>
										<li><?php _e( 'Activity to give children better educational environments', 'accf' ); ?></li>
										<li><?php _e( 'Activity to solve local issues', 'accf' ); ?></li>
										<li><?php _e( 'Activity to raise level of well-being of Aomori prefecture', 'accf' ); ?></li>
										<li><?php _e( 'Activity to encourage people to live in Aomori prefecture', 'accf' ); ?></li>
									</ul>
								</div>
								<div class="grid_4 indivisualfunds">
									<h4><?php _e( 'Individual Fund', 'accf' ); ?></h4>
								</div>
								<div class="clear">&nbsp;</div>
							</div>
						</div>

						<div class="box">
							<h3><?php _e( 'Pro bono', 'accf' ); ?></h3>
							<p><?php _e( 'In pro bono program, we look for volunteers, who are familliar with IT, accountancy and public relations, among experts and bussiness sectors and provide information of them on NPO Portal Site. This is a system that matches nonprofits with professional skills of for-profit sector.', 'accf' ); ?></p>
							<p><a href="<?php echo $accf['home_url']; ?>/programs/probono"><?php _e( 'Read more', 'accf' ); ?></a></p>
						</div>

						<div class="box">
							<h3><?php _e( 'Resource', 'accf' ); ?></h3>
							<p><?php _e( 'In resource endowment program, we look for unused tables, chairs, lockers and white boards in business sectors and provide information of them on NPO Portal Site. This is a system that matches nonprofits that want office products with business sectors that can provide them.', 'accf' ); ?></p>
							<p><a href="<?php echo $accf['home_url']; ?>/programs/resource"><?php _e( 'Read more', 'accf' ); ?></a></p>
						</div>
					</div><!-- .entry-content -->
				</article>

			</div>
			<div style="clear: both;"></div>
		</div>
<?php get_footer(); ?>