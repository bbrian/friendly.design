<?php

/*
	A callback function for the wp_list_comments function in single.php
*/

if(!function_exists('friendly_comment_callback')) :

	function friendly_comment_callback($comment, $args, $depth)
	{
	
		$GLOBALS['comment'] = $comment;
		?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			
				<div id="comment-<?php comment_ID(); ?>">
				
					<div class="comment-author vcard">
				
						<?php printf(__('<cite class="fn">%s</cite> <span class="wrote">wrote</span><br />'), get_comment_author_link()) ?>
						
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
							<?php printf(__('<span>on</span> %1$s<br/> <span>at</span> %2$s', THEMENAME), get_comment_date(),  get_comment_time()) ?>
						</a>
						
						<div class="comment_avatar avatar-comment-<?php comment_ID(); ?>">
							<?php echo get_avatar($comment,$size='32',$default=get_bloginfo("stylesheet_directory").'/admin/images/friendly-logo-32.png' ); ?>
						</div>
						
						<div class="reply">
							<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
						</div>
						
						<?php edit_comment_link(__('Edit', THEMENAME),'  ','') ?>
					</div>
				
					<div class="comment_text">
					
						<?php if ($comment->comment_approved == '0') : ?>
				
							<div class="comment_under_moderation">
								<em><?php _e('Your comment is awaiting moderation.', THEMENAME) ?></em>
							</div>
					
					<?php endif; ?>
					
						<?php comment_text() ?>
					</div>
				
				</div>

		<?php
		
		/* Note the lack of a trailing </li>. WP will add it itself once it's done listing any children and whatnot.  */
	
	}/* friendly_comment_callback() */

endif;

?>