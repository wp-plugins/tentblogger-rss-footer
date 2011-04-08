<![CDATA[ TentBlogger Add RSS Footer 1.0 ]]>
<?php $options = get_option('tentblogger-rss-footer'); ?>
<div class="wrap">
	<h2>
		<?php _e("TentBlogger's RSS Footer Plugin", "tentblogger-rss-footer"); ?>
	</h2>
	<div class="tentblogger-postbox postbox">
		<h3 class="tentblogger-hndle hndle">
			<span>
				<?php _e("RSS Footer Settings", "tentblogger-rss-footer"); ?>
			</span>
		</h3>
		<div class="tentblogger-inside inside">
			<?php if($is_updated) { ?>
				<div id="message" class="updated fade">
					<p>
						<?php _e('RSS Footer updated successfully!', 'tentblogger-rss-footer'); ?>
					</p>
				</div>
			<?php } // end if ?>
			<p>
				<?php _e("This plugin allows you to easily add content, links, or anything else you'd like at the end of blog post via your RSS feed. Create links to anywhere you'd like such as other blogs, other posts of interest, or even affiliate sponsors and products! Do whatever you'd like with it!", 'tentblogger-rss-footer'); ?>
			</p>
			<p>
				<?php _e("Read more about the plugin <a href=\"http://tentblogger.com/add-rss-feed\">here</a> and check out <a href=\"http://profiles.wordpress.org/users/tentblogger/\">my other plugins</a>!", 'tentblogger-rss-footer'); ?>
			</p>
		</div>
		<div id="rss-footer-message" class="tentblogger-inside inside">
			<h4>
				<?php _e('Custom RSS Message:', 'tentblogger-rss-footer'); ?>
			</h4>
			<p>
				<strong><?php _e('HTML Allowed!', 'tentblogger-rss-footer');?></strong>
			</p>
			<p>
				<span style="font-family: Consolas, Courier New, Courier, Monospace;">
					<?php echo allowed_tags(); ?>
				</span>
			</p>
			<form id="tentblogger-rss-footer-form" method="post" action="">
				<textarea id="tentblogger-rss-footer-content" name="tentblogger-rss-footer-content" cols="80" rows="5"><?php echo $options['tentblogger-rss-footer-content']; ?></textarea>
				<p class="submit" class="tentblogger-feedburner-submit">
					<?php wp_nonce_field('tentblogger-rss-footer', 'tentblogger-rss-footer-admin'); ?>
					<input type="submit" name="submit" id="tentblogger-rss-footer-content" name="tentblogger-rss-footer-content" class="button-primary" value="<?php _e('Save My RSS Footer Message!', 'tentblogger-rss-footer'); ?>" />
				</p>
			</form>
		</div>
		<div class="tentblogger-inside inside">
			<p>
				<?php _e('Feel free to <a href="http://twitter.com/tentblogger" target="_blank">follow me</a> on Twitter!', 'tentblogger-optimize-wordpress-database'); ?>
			</p>
		</div>
	</div>
</div>