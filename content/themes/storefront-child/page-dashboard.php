
<?php
/**

**Template Name: dashboard

 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
            while (have_posts()) :
                the_post();

                do_action('storefront_page_before');

                get_template_part('content', 'page');

                /**
                 * Functions hooked in to storefront_page_after action
                 *
                 * @hooked storefront_display_comments - 10
                 */
                do_action('storefront_page_after');

            endwhile; // End of the loop.
            ?>
	<?php
		$showmessage_settings_options = get_option('showmessage_settings_option_name');
		$showMessageText = $showmessage_settings_options ['text_1']; ?>
	<div class='showMessageText'> <?php echo $showMessageText;?></div>


<?php $val = get_post_meta($post->ID, '_ma_valeur', true);?>
<div class="metaboxText"><?php echo $val;?></div>

		
	
	</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action('storefront_sidebar');
get_footer();
