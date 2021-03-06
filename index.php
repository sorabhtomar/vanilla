<?php
/**
 * The main template file.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package vanilla
 */

get_header(); ?>
	<div id="primary">
		<main id="main" class="site-main" role="main">
			<?php do_action( 'vanilla_site_main_prepend' );?>

			<?php
			if ( have_posts() ) :?>
				<?php if ( ! is_front_page() ) : ?>
					<header class="archive-header">
						<div class="container">
							<h1 class="archive-header__title"><?php the_archive_title(); ?></h1>
							<?php echo term_description();?>
						</div>
					</header>
				<?php endif;?>

				<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content' );
				endwhile;

				the_posts_pagination( array(
					'prev_text' => '<span class="pagination__arrow dashicons dashicons-arrow-left-alt2"></span><span class="screen-reader-text">Prev</span>',
					'next_text' => '<span class="pagination__arrow dashicons dashicons-arrow-right-alt2"></span><span class="screen-reader-text">Next</span>',
					'before_page_number' => '<span class="pagination__numbers">',
					'after_page_number' => '</span>',

				) ); ?>

				<?php

			else :
				get_template_part( 'template-parts/content', 'none' );
			endif; ?>

		</main>
	</div>
<?php
get_footer();
