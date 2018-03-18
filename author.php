<?php get_header(); ?>

<section class="content">

	<?php get_template_part('inc/page-title'); ?>
	
	<div class="pad group">		
		
		<?php if (get_the_author_meta( 'display_name' ) ): ?>
			<div class="author-bio">
				<div class="bio-avatar"><?php echo get_avatar(get_the_author_meta('user_email'),'128'); ?></div>
				<p class="bio-name"><?php the_author_meta('display_name'); ?></p>
				<?php if (get_the_author_meta( 'blogrole' ) ): ?>
					<h2>Role:</h2><p class="bio-role"><?php the_author_meta('blogrole'); ?></p>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'degree' ) ): ?>
					<h2>Degrees:</h2><p class="bio-research"><?php the_author_meta('degree'); ?></p>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'currdegree' ) ): ?>
					<h2>Current Study:</h2><p class="bio-research"><?php the_author_meta('currdegree'); ?></p>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'research' ) ): ?>
					<h2>Research Topic:</h2><p class="bio-research"><?php the_author_meta('research'); ?></p>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'interests' ) ): ?>
					<h2>Research Interests:</h2><p class="bio-research"><?php the_author_meta('interests'); ?></p>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'dissertation' ) ): ?>
					<h2>Title of Dissertation:</h2><p class="bio-research"><?php the_author_meta('dissertation'); ?></p>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'description' ) ): ?>
					<h2>About Me:</h2><p class="bio-desc"><?php the_author_meta('description'); ?></p>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'user_url' ) ): ?>
					<h2>Website:</h2><a class="bio-url" href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta('user_url'); ?></a>
				<?php endif; ?>
        <?php if (get_the_author_meta( 'website' ) ): ?>
					<h2>Website:</h2><a class="bio-url" href="<?php the_author_meta('website'); ?>"><?php the_author_meta('website'); ?></a>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'twitter' ) || get_the_author_meta( 'facebook' ) || get_the_author_meta( 'linkedin' ) || get_the_author_meta( 'displayemail' )): ?>
					<h2>Social Links:</h2>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'displayemail' ) ): ?>
					<a class="bio-social" href="mailto:<?php the_author_meta('user_email'); ?>"><img src="http://icons.iconarchive.com/icons/zerode/plump/256/Mail-icon.png" alt="Email" style="height:15px" border="0"></a>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'twitter' ) ): ?>
					<a class="bio-social" href="https://www.twitter.com/<?php the_author_meta('twitter'); ?>"><img src="https://g.twimg.com/Twitter_logo_blue.png" alt="View twitter profile" style="height:15px" border="0"></a>
				<?php endif; ?>
				<?php if (get_the_author_meta( 'facebook' ) ): ?>
					<a class="bio-social" href="https://www.facebook.com/<?php the_author_meta('facebook'); ?>"><img src="http://historytothepublic.org/wp-content/uploads/2015/01/FB-f-Logo__blue_29.png" alt="View facebook profile" style="height:15px" border="0"></a>
				<?php endif; ?>
				
				<?php if (get_the_author_meta( 'linkedin' ) ): ?>
					<a class="bio-social" href="<?php the_author_meta('linkedin'); ?>"><img src="http://s.c.lnkd.licdn.com/scds/common/u/img/webpromo/btn_profile_bluetxt_80x15.png" alt="View  profile on LinkedIn" width="80" style="height:15px" border="0"></a>
				<?php endif; ?>
                                <?php if (get_the_author_meta( 'httper' ) ): ?>
					<h2>HTTPer Profile:</h2><a class="bio-url" href="<?php get_post_permalink(the_author_meta('httper')); ?>"><?php get_the_title(the_author_meta('httper')); ?></a>
				<?php endif; ?>
				<div class="clear"></div>
			</div>
		<?php endif; ?>
		<?php if ( get_the_author_meta( 'httper' ) ): ?>
			<?php $my_query = new WP_Query( array( 'author' => get_the_author_meta( 'ID' ),'p'=> the_author_meta('httper') ));
			while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
				<div class="post-inner group">
					
					<h1 class="post-title"><?php the_title(); ?></h1>
					<p class="post-byline"><?php _e('by','hueman'); ?> <?php if ( function_exists( 'coauthors_posts_links' ) ) {coauthors_posts_links();} else {the_author_posts_link();} ?> &middot; <?php the_time(get_option('date_format')); ?></p>
					
					<?php if( get_post_format() ) { get_template_part('inc/post-formats'); } ?>
					
					<div class="clear"></div>
					
					<div class="entry <?php if ( ot_get_option('sharrre') != 'off' ) { echo 'share'; }; ?>">	
						<div class="entry-inner">
							<?php the_content(); ?>
						</div>
						<div class="clear"></div>				
					</div><!--/.entry-->
					
				</div><!--/.post-inner-->
			<?php endwhile; ?>
    <?php rewind_posts(); ?>
		<?php endif; ?>
    
		<?php if ( have_posts() ) : ?>
			<div class="post-list group">
        <h2>Posts by author</h2>
				<?php $i = 1; echo '<div class="post-row">'; while ( have_posts() ): the_post(); ?>
				<?php get_template_part('content'); ?>
				<?php if($i % 2 == 0) { echo '</div><div class="post-row">'; } $i++; endwhile; echo '</div>'; ?>
			</div><!--/.post-list-->
		
			<?php get_template_part('inc/pagination'); ?>
			
		<?php endif; ?>
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>