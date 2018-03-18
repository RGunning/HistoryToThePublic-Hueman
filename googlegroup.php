<?php
/*
Template Name: GoogleGroup
*/
?>

<script type="text/javascript">
window.onload = function() {
  document.getElementById('forum_embed').src = 'https://groups.google.com/forum/embed/?place=forum/historytothepublic'
     + '&showsearch=true&showpopout=true&showtabs=false'
     + '&parenturl=' + encodeURIComponent(window.location.href);
};
</script>

<?php get_header(); ?>

<section class="content">
	
	<?php get_template_part('inc/page-title'); ?>
	
	<div class="pad group">
		
		<?php while ( have_posts() ): the_post(); ?>
			<article <?php post_class(); ?>>	
				<div class="post-inner group">
					
					<h1 class="post-title"><?php the_title(); ?></h1>
					<p class="post-byline"><?php _e('by','hueman'); ?> <?php if ( function_exists( 'coauthors_posts_links' ) ) {coauthors_posts_links();} else {the_author_posts_link();} ?> &middot; <?php the_time(get_option('date_format')); ?></p>
					
					<?php if( get_post_format() ) { get_template_part('inc/post-formats'); } ?>
					
					<div class="clear"></div>
					
					<div class="entry <?php if ( ot_get_option('sharrre') != 'off' ) { echo 'share'; }; ?>">	
						<div class="entry-inner">
							<?php the_content(); ?>
							<?php wp_link_pages(array('before'=>'<div class="post-pages">'.__('Pages:','hueman'),'after'=>'</div>')); ?>
						</div>
						<div class="clear"></div>				
					</div><!--/.entry-->
					
				</div><!--/.post-inner-->	
			</article><!--/.post-->				
		<?php endwhile; ?>
		
		<div class="clear"></div>
		
		<?php the_tags('<p class="post-tags"><span>'.__('Tags:','hueman').'</span> ','','</p>'); ?>
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>