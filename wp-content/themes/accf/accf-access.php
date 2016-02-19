<?php
/*
Template Name: アクセスページ
*/
$is_EN = ( 'en' == qtrans_getLanguage() ) ? true : false;
$googlemapapi = 'http://maps.google.com/maps/api/js?sensor=false';
if( $is_EN )
	$googlemapapi .= '&language=en';
wp_enqueue_script('googlemap', $googlemapapi, array(), null);
get_header( );
?>

		<div class="container_12">

			<?php get_sidebar(  ); ?>

			<div id="content" class="grid_8">
				<div class="post-entries">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
							<h2 class="entry-title"><?php the_title(); ?></h2>
						</header>
						<div class="entry-content">
							<div id="office-map" style="width: 620px; height: 400px; margin: 0 auto 1em;"></div>
							<script type="text/javascript">(function(){var latlng = new google.maps.LatLng(40.826382, 140.739618);var myOptions = {zoom: 15,center: latlng,mapTypeId: google.maps.MapTypeId.ROADMAP};var map = new google.maps.Map(document.getElementById("office-map"),myOptions);var marker = new google.maps.Marker({position: latlng,map: map,title:"あおもりＮＰＯサポートセンター"});})();</script>

							<ul>
								<li><?php _e( '5-minute walk from Aomori station', 'accf' ); ?></li>
								<li><?php _e( '3-minute walk from Nakasan-mae station of municiapl bus', 'accf' ); ?></li>
								<li><?php _e( '2-minute walk from Shin-machi Ittyome station of municipal bus', 'accf' ); ?></li>
							</ul>

							<div class="box">
								<?php if( $is_EN ) : ?>
								Wada building 2F, 1-13-7, Shin-machi, Aomori, 030-0801<br />
								TEL 017-752-9095 / FAX 017-852-9097<br />
								from 9am to 5pm Monday-Friday (except public holidays)<br />
								<?php else : ?>
								〒０３０−０８０１<br />
								青森市新町１丁目１３−７　和田ビル２F<br />
								ＴＥＬ：０１７−７５２−９０９５<br />
								ＦＡＸ：０１７−７５２−９０９７
								<?php endif; ?>
							</div>

						</div><!-- .entry-content -->
						<footer class="entry-meta"></footer>
					</article>
				</div><!-- .post-entries -->
			</div>
			<div style="clear: both;"></div>
		</div>
<?php get_footer(); ?>