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
 * Normalize plain-text content for prompts and data attributes.
 *
 * @param string $text Raw text.
 * @return string
 */
function dhf_normalize_prompt_text( $text ) {
	$text = html_entity_decode( wp_strip_all_tags( (string) $text ), ENT_QUOTES, get_bloginfo( 'charset' ) );
	$text = preg_replace( '/\s+/u', ' ', trim( $text ) );

	return is_string( $text ) ? $text : '';
}

/**
 * Extract a short list of section headings from article content.
 *
 * @param string $content Article HTML.
 * @return string[]
 */
function dhf_extract_article_headings( $content ) {
	$headings = array();

	if ( preg_match_all( '/<h[2-4][^>]*>(.*?)<\/h[2-4]>/is', $content, $matches ) ) {
		foreach ( $matches[1] as $heading ) {
			$heading = dhf_normalize_prompt_text( $heading );

			if ( '' === $heading ) {
				continue;
			}

			$headings[] = $heading;

			if ( count( $headings ) >= 6 ) {
				break;
			}
		}
	}

	return $headings;
}

/**
 * Build normalized article context used by AI prompts.
 *
 * @param int    $post_id Current post ID.
 * @param string $content Article HTML.
 * @return array<string, string>
 */
function dhf_get_article_prompt_context( $post_id, $content ) {
	$post_title = dhf_normalize_prompt_text( get_the_title( $post_id ) );
	$post_url   = get_permalink( $post_id );
	$site_name  = dhf_normalize_prompt_text( get_bloginfo( 'name' ) );

	// Bolt optimization: Replace wp_get_post_terms with get_the_terms + wp_list_pluck to leverage object cache and avoid N+1 queries
	$cat_terms  = get_the_terms( $post_id, 'category' );
	$categories = ( ! empty( $cat_terms ) && ! is_wp_error( $cat_terms ) ) ? wp_list_pluck( $cat_terms, 'name' ) : array();
	$tag_terms  = get_the_terms( $post_id, 'post_tag' );
	$tags       = ( ! empty( $tag_terms ) && ! is_wp_error( $tag_terms ) ) ? wp_list_pluck( $tag_terms, 'name' ) : array();

	$lead       = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : $content;
	$lead       = wp_trim_words( dhf_normalize_prompt_text( $lead ), 55, '...' );
	$body       = wp_trim_words( dhf_normalize_prompt_text( $content ), 220, '...' );
	$headings   = dhf_extract_article_headings( $content );

	return array(
		'post_title'    => $post_title,
		'post_url'      => $post_url,
		'site_name'     => $site_name,
		'category_line' => ! empty( $categories ) ? implode( ', ', array_map( 'dhf_normalize_prompt_text', $categories ) ) : 'Not specified',
		'tag_line'      => ! empty( $tags ) ? implode( ', ', array_map( 'dhf_normalize_prompt_text', $tags ) ) : 'Not specified',
		'heading_line'  => ! empty( $headings ) ? implode( ' | ', $headings ) : 'No subheadings extracted',
		'lead'          => $lead,
		'body'          => $body,
	);
}

/**
 * Return the editable prompt template for article AI tools.
 *
 * Keep the prompt copy in one place so it is easy to change later.
 *
 * @param array<string, string> $context Normalized article context.
 * @return string[]
 */
function dhf_get_article_prompt_sections( $context ) {
	return array(
		'Act as a local design curator, Krakow guide, and personal concierge representing ' . $context['site_name'] . '.',
		'Goal: turn this article into a concrete, original city route for a visitor interested in design, architecture, visual culture, and urban details.',
		'Treat the article content as the primary reference material. Base your interpretation, route logic, and recommendations mainly on the information and cues provided below.',
		implode(
			"\n",
			array(
				'Reference material:',
				'Article title: ' . $context['post_title'],
				'URL: ' . $context['post_url'],
				'Category: ' . $context['category_line'],
				'Tags: ' . $context['tag_line'],
				'Subheadings: ' . $context['heading_line'],
				'Lead / summary: ' . $context['lead'],
				'Condensed article body: ' . $context['body'],
			)
		),
		'If you do not have explicit user preferences, infer the most likely interests from the category, tags, and article content. Name them briefly as "Assumed Interests".',
		implode(
			"\n",
			array(
				'Complete the task as a city route plan:',
				'1. Extract the main design or historical theme from the article and use it as the route spine.',
				'2. Suggest the Krakow district, street cluster, or type of area where the visitor should begin.',
				'3. Build a short discovery route with 4-6 stops: what to see, which details to notice, and why each stop fits the article theme.',
				'4. Add practical recommendations: where to stop for coffee and cake, where to find a souvenir or design-related object, and where to have lunch, while keeping the design theme in the background.',
				'5. Add 1 next article from Design History Forum that naturally extends this route.',
				'6. If you are not certain about specific addresses or partners, do not invent names. Instead, describe the type of place, the atmosphere, and the reason for the recommendation.',
			)
		),
		implode(
			"\n",
			array(
				'Format the response in Markdown using five sections:',
				'Design Route: 1 short paragraph explaining the route theme and who it is for.',
				'City Fragment: identify the part of the city or type of place where the route should begin.',
				'What To See: a list of route stops with short curatorial notes.',
				'Where To Stop: three subsections: coffee & cake, souvenir / design object, lunch.',
				'Next Step: 1 next DHF article and 1 short reason why it is the right continuation.',
			)
		),
		'Respond in an enthusiastic, professional, urban, and specific tone. Be direct and avoid filler.',
		'Do not invent quotes or facts outside the reference material. If you infer something, label it as interpretation.',
		'Respond in English unless the user explicitly asks for another language.',
	);
}

/**
 * Return AI tool definitions in one editable place.
 *
 * @param string $icons_base Base URL for tool icons.
 * @return array<int, array<string, string>>
 */
function dhf_get_article_ai_tool_definitions( $icons_base ) {
	return array(
		array(
			'label'        => 'ChatGPT',
			'icon'         => $icons_base . 'gpt.svg',
			'url_template' => 'https://chatgpt.com/?hints=search&prompt=%s',
			'launch_mode'  => 'prefill',
			'copy_notice'  => 'Prompt copied for ChatGPT. Paste with Ctrl+V if needed.',
		),
		array(
			'label'        => 'Claude',
			'icon'         => $icons_base . 'claude.svg',
			'url_template' => 'https://claude.ai/new?q=%s',
			'launch_mode'  => 'prefill',
			'copy_notice'  => 'Prompt copied for Claude. Paste with Ctrl+V if needed.',
		),
		array(
			'label'        => 'Gemini',
			'icon'         => $icons_base . 'gemini.svg',
			'url_template' => 'https://gemini.google.com/app',
			'launch_mode'  => 'clipboard_modal',
			'copy_notice'  => 'Prompt copied for Gemini. Open the chat box and paste with Ctrl+V.',
		),
		array(
			'label'        => 'Perplexity',
			'icon'         => $icons_base . 'perplexity.svg',
			'url_template' => 'https://www.perplexity.ai/search/new?q=%s',
			'launch_mode'  => 'prefill',
			'copy_notice'  => 'Prompt copied for Perplexity. Paste with Ctrl+V if needed.',
		),
		array(
			'label'        => 'Groq',
			'icon'         => '',
			'badge_text'   => 'groq',
			'url_template' => 'https://chat.groq.com/',
			'launch_mode'  => 'clipboard_modal',
			'copy_notice'  => 'Prompt copied for Groq. Paste with Ctrl+V in the chat input.',
		),
	);
}

/**
 * Resolve AI tool links from one shared configuration.
 *
 * @param string $icons_base Base URL for tool icons.
 * @param string $prompt     Prepared article prompt.
 * @return array<int, array<string, string>>
 */
function dhf_prepare_article_ai_tools( $icons_base, $prompt ) {
	$prompt_url = rawurlencode( $prompt );
	$tools      = array();

	foreach ( dhf_get_article_ai_tool_definitions( $icons_base ) as $tool ) {
		$tool['url'] = false !== strpos( $tool['url_template'], '%s' )
			? sprintf( $tool['url_template'], $prompt_url )
			: $tool['url_template'];

		$tools[] = $tool;
	}

	return $tools;
}

/**
 * Build a structured AI prompt from the current article.
 *
 * @param int    $post_id Current post ID.
 * @param string $content Article HTML.
 * @return string
 */
function dhf_build_article_prompt( $post_id, $content ) {
	$context  = dhf_get_article_prompt_context( $post_id, $content );
	$sections = dhf_get_article_prompt_sections( $context );

	return implode( "\n\n", $sections );
}

/**
 * Insert AI summary/share tools at the start of article content.
 *
 * @param string $content Post content.
 * @return string
 */
function dhf_append_article_tools( $content ) {
	static $rendered_posts = array();

	if ( is_admin() || ! is_singular( 'post' ) ) {
		return $content;
	}

	$post_id = (int) get_the_ID();

	if ( $post_id !== (int) get_queried_object_id() ) {
		return $content;
	}

	if ( in_array( $post_id, $rendered_posts, true ) ) {
		return $content;
	}

	$post_url   = get_permalink( $post_id );
	$post_title = wp_strip_all_tags( get_the_title( $post_id ) );
	$prompt     = dhf_build_article_prompt( $post_id, $content );
	$icons_base = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/images/ai-icons/';
	$ai_tools   = dhf_prepare_article_ai_tools( $icons_base, $prompt );
	$instruction_graphic = trailingslashit( get_stylesheet_directory_uri() ) . 'nstrukcja.png';

	$rendered_posts[] = $post_id;

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
			<p class="dhf-article-tools__label">Plan with AI:</p>
			<div class="dhf-article-tools__actions" aria-label="AI summary tools">
				<?php foreach ( $ai_tools as $tool ) : ?>
					<a
						class="dhf-article-tools__chip dhf-article-tools__chip--ai"
						href="<?php echo esc_url( $tool['url'] ); ?>"
						target="_blank"
						rel="noopener noreferrer"
						data-ai-tool
						data-ai-label="<?php echo esc_attr( $tool['label'] ); ?>"
						data-ai-launch-mode="<?php echo esc_attr( $tool['launch_mode'] ); ?>"
						data-ai-copy-notice="<?php echo esc_attr( $tool['copy_notice'] ); ?>"
					>
						<span class="dhf-article-tools__badge" aria-hidden="true">
							<?php if ( ! empty( $tool['icon'] ) ) : ?>
								<img
									class="dhf-article-tools__icon"
									src="<?php echo esc_url( $tool['icon'] ); ?>"
									alt=""
									loading="lazy"
									decoding="async"
								/>
							<?php elseif ( ! empty( $tool['badge_text'] ) ) : ?>
								<span class="dhf-article-tools__icon-text"><?php echo esc_html( $tool['badge_text'] ); ?></span>
							<?php endif; ?>
						</span>
						<span class="screen-reader-text"><?php echo esc_html( $tool['label'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
			<p class="dhf-article-tools__hint">Click an icon to open AI with a ready task. The article content is included as reference material. ChatGPT, Claude, and Perplexity use a prompt link, while Gemini and Groq open chat with the prompt copied to your clipboard.</p>
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
		<div class="dhf-ai-modal" data-ai-modal hidden>
			<div class="dhf-ai-modal__backdrop" data-ai-modal-close></div>
			<div
				class="dhf-ai-modal__dialog"
				role="dialog"
				aria-modal="true"
				aria-labelledby="dhf-ai-modal-title-<?php echo esc_attr( $post_id ); ?>"
			>
				<button class="dhf-ai-modal__close" type="button" data-ai-modal-close aria-label="Close instructions">
					<span aria-hidden="true">x</span>
				</button>
				<p class="dhf-ai-modal__eyebrow">Clipboard flow</p>
				<h3 class="dhf-ai-modal__title" id="dhf-ai-modal-title-<?php echo esc_attr( $post_id ); ?>" data-ai-modal-title>
					Finish in Gemini
				</h3>
				<p class="dhf-ai-modal__copy">
					Your prompt is already in the clipboard. Follow these steps to continue in <span data-ai-modal-tool-name>Gemini</span>.
				</p>
				<figure class="dhf-ai-modal__graphic">
					<img
						class="dhf-ai-modal__graphic-image"
						src="<?php echo esc_url( $instruction_graphic ); ?>"
						alt="Three steps: prompt copied, open chat, paste with Ctrl plus V."
						loading="lazy"
						decoding="async"
					/>
				</figure>
				<ol class="dhf-ai-modal__steps">
					<li>Open <span data-ai-modal-tool-name>Gemini</span> in a new tab.</li>
					<li>Click the chat input field.</li>
					<li>Paste the copied prompt with <strong>Ctrl+V</strong>.</li>
				</ol>
				<div class="dhf-ai-modal__actions">
					<button class="dhf-ai-modal__button dhf-ai-modal__button--primary" type="button" data-ai-modal-open>
						Open <span data-ai-modal-tool-name>Gemini</span>
					</button>
					<button class="dhf-ai-modal__button dhf-ai-modal__button--secondary" type="button" data-ai-modal-copy>
						Copy prompt again
					</button>
				</div>
			</div>
		</div>
	</section>
	<?php

	return ob_get_clean() . $content;
}
add_filter( 'the_content', 'dhf_append_article_tools' );
