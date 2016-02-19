<?php
/*
Template Name: サイトマップページ
*/
get_header();
?>

		<div class="container_12">
			<!-- begin sidebar -->
			<?php get_sidebar(); ?>
			<!-- end sidebar -->
			<div id="content" class="grid_8">
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header>
						<h2><?php the_title(); ?></h2>
					</header>

					<div class="entry-content" id="sitemap">

						<div class="grid_8 category">
							<div class="grid_3">
								<h4><a href="<?php echo home_url(); ?>">ホーム</a></h4>
							</div>
						</div>
						<div class="grid_8 category" style="height: 80px;">
							<div class="grid_2" style="margin-right: 0;">
								<h4><a href="<?php  echo home_url(); ?>/about">組織</a></h4>
							</div>
							<div class="grid_6" style="margin-left: 0;margin-right: 0;">
								<ul>
									<li><a href="<?php echo home_url(); ?>/about/background">設立の背景</a></li>
									<li><a href="<?php echo home_url(); ?>/about/organization">法人情報</a></li>
									<li><a href="<?php echo home_url(); ?>/about/executive">理事、監事、評議員</a></li>
									<li><a href="<?php echo home_url(); ?>/about/publications">開示情報</a></li>
									<li><a href="<?php echo home_url(); ?>/about/access">アクセス</a></li>
								</ul>
							</div>
						</div>
						<div class="grid_8 category" style="height: 80px;">
							<div class="grid_2" style="margin-right: 0;">
								<h4><a href="<?php bloginfo(); ?>/programs">事業</a></h4>
							</div>
							<div class="grid_6" style="margin-right: 0;margin-left: 0;">
								<ul>
									<li><a href="<?php echo home_url(); ?>/programs/give-funds">寄付と基金</a></li>
									<li><a href="<?php echo home_url(); ?>/programs/grants">助成支援</a></li>
									<li><a href="<?php echo home_url(); ?>/programs/protalsite">ＮＰＯポータルサイト</a></li>
									<li><a href="<?php echo home_url(); ?>/programs/probono">プロボノ</a></li>
									<li><a href="<?php echo home_url(); ?>/programs/resources">資源提供</a></li>
								</ul>
							</div>
						</div>

						<div class="grid_8 category">
							<div class="grid_3">
								<h4><a href="<?php echo home_url(); ?>/news">お知らせ</a></h4>
							</div>
						</div>
						<div class="grid_8 category">
							<div class="grid_3">
								<h4><a href="<?php echo home_url(); ?>/give">寄付をする</a></h4>
							</div>
						</div>
						<div class="grid_8 category">
							<div class="grid_3">
								<h4><a href="<?php echo home_url(); ?>/files">資料</a></h4>
							</div>
						</div>
						<div class="grid_8 category">
							<div class="grid_3">
								<h4><a href="<?php echo home_url(); ?>/contact">お問い合わせ</a></h4>
							</div>
						</div>
						<div class="grid_8 category">
							<div class="grid_3">
								<h4><a href="<?php echo home_url(); ?>/faqs">よくあるご質問</a></h4>
							</div>
						</div>
						<div class="grid_8 category">
							<div class="grid_3">
								<h4><a href="<?php echo home_url(); ?>/sitemap">サイトマップ</a></h4>
							</div>
						</div>

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