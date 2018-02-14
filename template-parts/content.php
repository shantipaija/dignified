<?php
/**
 * @package dignified
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/CreativeWork">
	<div class="blog-item-wrap">
        <?php
        $featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

        if  ( ! empty( $featured_image_url ) ) : ?>
            <div class="imghov">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<div class="tiles">
				    <div data-scale="1.3" data-image="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>"
                    class="zoom-thumbnail-tile  <?php
                    if ( is_page_template( 'page-fullwidth.php' ) ) {
                        echo "single-featured fullwidth";
                    } else {
                        echo "single-featured sidebars ";
                    }

                    echo get_the_ID()
                    ?> " ></div>
				</div>
                </a>
            </div>
        <?php endif; ?>
		<div class="post-inner-content">
			<header class="entry-header page-header">

				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
						//if ( get_theme_mod( 'dignified_post_date' ) == 1 ) :
							dignified_posted_on();
						//endif;
					?>


					<?php
                    if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                        <span class="comments-link"><i class="fa fa-comment-o"></i><?php comments_popup_link( esc_html__( 'Leave a comment', 'dignified' ), esc_html__( '1 Comment', 'dignified' ), esc_html__( '% Comments', 'dignified' ) ); ?></span>
                    <?php endif; ?>


				</div><!-- .entry-meta -->
                <div>
                <?php socialmedia_share_button(); ?>
                    <?php if ( get_edit_post_link() ) : ?>
					<?php
						edit_post_link(
							sprintf(
								/* translators: %s: Name of current post */
								esc_html__( 'Edit %s', 'dignified' ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							),
							'<i class="fa fa-pencil-square-o"></i><span class="edit-link">',
							'</span>'
						);
					?>
                    <?php endif; ?>
                </div>
				<?php endif; ?>
			</header><!-- .entry-header -->

			<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
				<p><a class="btn btn-default read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'dignified' ); ?></a></p>
			</div><!-- .entry-summary -->
			<?php else : ?>
			<div class="entry-content">
                <?php // the_content(); ?>
                <?php //the_content( esc_html__( 'Read More...', 'dignified' ) ); ?>

			<?php

                if ( (get_theme_mod( 'dignified_excerpts' ) == 1 ) && (! is_single()) ) {
					the_excerpt();?>
					<p><a class="btn btn-default read-more" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( 'Read More', 'dignified' ); ?></a></p>
                    <?php
                }else{
                    the_content( esc_html__( 'Read More', 'dignified' ) );
                }

            ?>
				<?php
                /*
				if ( get_theme_mod( 'dignified_excerpts' ) == 1 ) :
					the_excerpt();?>
					<p><a class="btn btn-default read-more" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html_e( 'Read More', 'dignified' ); ?></a></p>
				<?php else :
					the_content( esc_html__( 'Read More', 'dignified' ) );
				endif;
                */
					?>

				<?php
					wp_link_pages( array(
						'before'            => '<div class="page-links">' . esc_html__( 'Pages:', 'dignified' ),
						'after'             => '</div>',
						'link_before'       => '<span>',
						'link_after'        => '</span>',
						'pagelink'          => '%',
						'echo'              => 1,
					) );
				?>
			</div><!-- .entry-content -->
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-## -->
