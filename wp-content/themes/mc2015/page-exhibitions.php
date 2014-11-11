<?php
	$args = array( 'post_type' => 'exhibition', 'posts_per_page' => 50 );
	$loop = new WP_Query( $args );
?>
<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<div class="exhibition-current" style="background-image: url(http://dev.mor-charpentier.com/wp-content/uploads/2013/10/Still-Aftershock4.jpg)">
			<div class="exhibition-content">
				<div class="exhibition-type">Current exhibition</div>
				<h2 class="exhibition-title"><a href="http://dev.mor-charpentier.com/exhibition/illimitee-promesse-davenir/">Illimitée promesse d'avenir</a></h2>
				<h4 class="exhibition-detail">6 Septembre 2014, 16h-21h Vernissage en présence de l'artiste</h4>
				<h4 class="exhibition-detail">6 Septembre-11 Octobre 2014 du mardi au samedi, 11h-19h</h4>
				<div class="exhibition-text">
					<p>Le déclin collectif de l’URSS d’une part, et des entreprises industrielles du Nord de la France d’autre part, se sont accompagnés d’un déclin individuel qui est au cœur des projets d’Uriel Orlow et de Natacha Nisic. Ce sont en effet les conséquences humaines de ces échecs politiques, sociaux et économiques, et le devenir des personnes qui sont interrogés par les deux artistes.</p>
				</div>
				<div class="post-share">
					<div class="post-share-text"><?php _e( 'Share', 'mor'); ?></div>
					<ul class="social-networks">
						<li class="social-network"><a href="" class="icon-facebook"></a></li>
						<li class="social-network"><a href="" class="icon-twitter"></a></li>
						<li class="social-network"><a href="" class="icon-instagram"></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="past-exhibitions">
			<div class="exhibition-type">Past exhibitions</div>
			<div class="past-exhibition-by-year">
				<button class="exhibition-close">x</button>
				<h2 class="past-exhibition-year"><a href="#">2014</a></h2>
				<div class="exhibition-past">
					<div class="exhibition-img" style="background-image: url(http://dev.mor-charpentier.com/wp-content/uploads/2013/09/mor.charpentier.Palimpsestes.Septembre-2013.jpg)"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/"></a></div>
					<h2 class="exhibition-title"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/">Palimpsestes</a></h2>
					<h4 class="exhibition-detail">6 Septembre-11 Octobre</h4>
				</div>
				<div class="exhibition-past">
					<div class="exhibition-img" style="background-image: url(http://dev.mor-charpentier.com/wp-content/uploads/2013/09/mor.charpentier.Palimpsestes.Septembre-2013.jpg)"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/"></a></div>
					<h2 class="exhibition-title"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/">Palimpsestes</a></h2>
					<h4 class="exhibition-detail">6 Septembre-11 Octobre</h4>
				</div>
				<div class="exhibition-past">
					<div class="exhibition-img" style="background-image: url(http://dev.mor-charpentier.com/wp-content/uploads/2013/09/mor.charpentier.Palimpsestes.Septembre-2013.jpg)"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/"></a></div>
					<h2 class="exhibition-title"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/">Palimpsestes</a></h2>
					<h4 class="exhibition-detail">6 Septembre-11 Octobre</h4>
				</div>
				<div class="exhibition-past">
					<div class="exhibition-img" style="background-image: url(http://dev.mor-charpentier.com/wp-content/uploads/2013/09/mor.charpentier.Palimpsestes.Septembre-2013.jpg)"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/"></a></div>
					<h2 class="exhibition-title"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/">Palimpsestes</a></h2>
					<h4 class="exhibition-detail">6 Septembre-11 Octobre</h4>
				</div>
				<div class="exhibition-past">
					<div class="exhibition-img" style="background-image: url(http://dev.mor-charpentier.com/wp-content/uploads/2013/09/mor.charpentier.Palimpsestes.Septembre-2013.jpg)"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/"></a></div>
					<h2 class="exhibition-title"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/">Palimpsestes</a></h2>
					<h4 class="exhibition-detail">6 Septembre-11 Octobre</h4>
				</div>
				<div class="exhibition-past">
					<div class="exhibition-img" style="background-image: url(http://dev.mor-charpentier.com/wp-content/uploads/2013/09/mor.charpentier.Palimpsestes.Septembre-2013.jpg)"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/"></a></div>
					<h2 class="exhibition-title"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/">Palimpsestes</a></h2>
					<h4 class="exhibition-detail">6 Septembre-11 Octobre</h4>
				</div>
			</div>
		</div>
	</main>
</div>
<?php get_footer(); ?>