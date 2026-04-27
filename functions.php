<?php
/**
 * Kadence Child theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register front-end assets for the child theme.
 */
function dhf_kadence_child_enqueue_styles() {
	$theme         = wp_get_theme();
	$parent_theme  = $theme->parent();
	$child_css_rel = '/assets/css/custom.css';
	$child_css_abs = get_stylesheet_directory() . $child_css_rel;
	$google_fonts  = 'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wdth,wght@12..96,75..100,400..800&family=Inter:wght@400;500;600;700;800&display=swap';

	wp_enqueue_style(
		'kadence-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		$parent_theme ? $parent_theme->get( 'Version' ) : null
	);

	wp_enqueue_style(
		'dhf-google-fonts',
		$google_fonts,
		array(),
		null
	);

	wp_enqueue_style(
		'kadence-child-style',
		get_stylesheet_directory_uri() . $child_css_rel,
		array( 'kadence-parent-style', 'dhf-google-fonts' ),
		file_exists( $child_css_abs ) ? filemtime( $child_css_abs ) : $theme->get( 'Version' )
	);

	if ( is_front_page() ) {
		wp_enqueue_script(
			'dhf-homepage-cards',
			get_stylesheet_directory_uri() . '/assets/js/homepage-cards.js',
			array(),
			file_exists( get_stylesheet_directory() . '/assets/js/homepage-cards.js' )
				? filemtime( get_stylesheet_directory() . '/assets/js/homepage-cards.js' )
				: $theme->get( 'Version' ),
			true
		);
	}

	if ( is_singular( 'post' ) ) {
		wp_enqueue_script(
			'dhf-article-tools',
			get_stylesheet_directory_uri() . '/assets/js/article-tools.js',
			array(),
			file_exists( get_stylesheet_directory() . '/assets/js/article-tools.js' )
				? filemtime( get_stylesheet_directory() . '/assets/js/article-tools.js' )
				: $theme->get( 'Version' ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'dhf_kadence_child_enqueue_styles' );

/**
 * Insert AI summary/share tools at the start of article content.
 *
 * @param string $content Post content.
 * @return string
 */
function dhf_append_article_tools( $content ) {
	if ( is_admin() || ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	if ( get_the_ID() !== (int) get_queried_object_id() ) {
		return $content;
	}

	$post_url   = get_permalink();
	$post_title = wp_strip_all_tags( get_the_title() );
	$site_name  = get_bloginfo( 'name' );
	$prompt     = sprintf(
		'Please summarize this article in 5 bullet points, then list 3 key takeaways and 3 related topics to explore. Article title: %1$s. Website: %2$s. URL: %3$s',
		$post_title,
		$site_name,
		$post_url
	);

	$ai_tools = array(
		array(
			'label' => 'ChatGPT',
			'badge' => 'GPT',
			'url'   => 'https://chatgpt.com/',
		),
		array(
			'label' => 'Claude',
			'badge' => 'CL',
			'url'   => 'https://claude.ai/new',
		),
		array(
			'label' => 'Gemini',
			'badge' => 'GM',
			'url'   => 'https://gemini.google.com/app',
		),
		array(
			'label' => 'Perplexity',
			'badge' => 'PX',
			'url'   => 'https://www.perplexity.ai/',
		),
		array(
			'label' => 'Grok',
			'badge' => 'GX',
			'url'   => 'https://grok.com/',
		),
	);

	$share_links = array(
		array(
			'label' => 'X',
			'badge' => 'X',
			'url'   => 'https://twitter.com/intent/tweet?url=' . rawurlencode( $post_url ) . '&text=' . rawurlencode( $post_title ),
		),
		array(
			'label' => 'Facebook',
			'badge' => 'f',
			'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( $post_url ),
		),
		array(
			'label' => 'LinkedIn',
			'badge' => 'in',
			'url'   => 'https://www.linkedin.com/sharing/share-offsite/?url=' . rawurlencode( $post_url ),
		),
	);

	ob_start();
	?>
	<section
		class="dhf-article-tools"
		data-dhf-article-tools
		data-prompt="<?php echo esc_attr( $prompt ); ?>"
		data-url="<?php echo esc_url( $post_url ); ?>"
		data-title="<?php echo esc_attr( $post_title ); ?>"
	>
		<div class="dhf-article-tools__group">
			<p class="dhf-article-tools__label">Podsumuj z AI:</p>
			<div class="dhf-article-tools__actions" aria-label="AI summary tools">
				<?php foreach ( $ai_tools as $tool ) : ?>
					<a
						class="dhf-article-tools__chip dhf-article-tools__chip--ai"
						href="<?php echo esc_url( $tool['url'] ); ?>"
						target="_blank"
						rel="noopener noreferrer"
						data-ai-tool
						data-ai-label="<?php echo esc_attr( $tool['label'] ); ?>"
					>
						<span class="dhf-article-tools__badge" aria-hidden="true"><?php echo esc_html( $tool['badge'] ); ?></span>
						<span class="screen-reader-text"><?php echo esc_html( $tool['label'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
			<p class="dhf-article-tools__hint">Klikniecie kopiuje prompt i otwiera wybrane narzedzie w nowej karcie.</p>
		</div>
		<div class="dhf-article-tools__group dhf-article-tools__group--share">
			<p class="dhf-article-tools__label">Share:</p>
			<div class="dhf-article-tools__actions" aria-label="Share article">
				<button class="dhf-article-tools__chip dhf-article-tools__chip--share" type="button" data-copy-link>
					<span class="dhf-article-tools__badge" aria-hidden="true">link</span>
					<span class="screen-reader-text">Copy article link</span>
				</button>
				<?php foreach ( $share_links as $share ) : ?>
					<a
						class="dhf-article-tools__chip dhf-article-tools__chip--share"
						href="<?php echo esc_url( $share['url'] ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<span class="dhf-article-tools__badge" aria-hidden="true"><?php echo esc_html( $share['badge'] ); ?></span>
						<span class="screen-reader-text"><?php echo esc_html( $share['label'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="dhf-article-tools__toast" aria-live="polite" data-ai-toast hidden></div>
	</section>
	<?php

	return ob_get_clean() . $content;
}
add_filter( 'the_content', 'dhf_append_article_tools' );
