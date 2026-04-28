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
 * Build a structured AI prompt from the current article.
 *
 * @param int    $post_id  Current post ID.
 * @param string $content  Article HTML.
 * @return string
 */
function dhf_build_article_prompt( $post_id, $content ) {
	$post_title = dhf_normalize_prompt_text( get_the_title( $post_id ) );
	$post_url   = get_permalink( $post_id );
	$site_name  = dhf_normalize_prompt_text( get_bloginfo( 'name' ) );
	$categories = wp_get_post_terms( $post_id, 'category', array( 'fields' => 'names' ) );
	$tags       = wp_get_post_terms( $post_id, 'post_tag', array( 'fields' => 'names' ) );
	$lead       = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : $content;
	$lead       = wp_trim_words( dhf_normalize_prompt_text( $lead ), 55, '…' );
	$body       = wp_trim_words( dhf_normalize_prompt_text( $content ), 220, '…' );
	$headings   = dhf_extract_article_headings( $content );

	$category_line = ! empty( $categories ) ? implode( ', ', array_map( 'dhf_normalize_prompt_text', $categories ) ) : 'Not specified';
	$tag_line      = ! empty( $tags ) ? implode( ', ', array_map( 'dhf_normalize_prompt_text', $tags ) ) : 'Not specified';
	$heading_line  = ! empty( $headings ) ? implode( ' | ', $headings ) : 'No subheadings extracted';

	$sections = array(
		'Działaj jako lokalny kurator designu, przewodnik po Krakowie i osobisty concierge reprezentujący ' . $site_name . '.',
		'Cel: zamień ten artykuł w konkretną, autorską ścieżkę zwiedzania dla turysty zainteresowanego designem, architekturą, kulturą wizualną i miejskimi detalami.',
		implode(
			"\n",
			array(
				'Materiał źródłowy:',
				'Tytuł artykułu: ' . $post_title,
				'URL: ' . $post_url,
				'Kategoria wpisu: ' . $category_line,
				'Tagi wpisu: ' . $tag_line,
				'Śródtytuły: ' . $heading_line,
				'Lead / skrót: ' . $lead,
				'Skrócona treść artykułu: ' . $body,
			)
		),
		'Jeśli nie masz jawnych preferencji użytkownika, wywnioskuj najbardziej prawdopodobne zainteresowania na podstawie kategorii, tagów i treści artykułu. Nazwij je krótko jako "Założone zainteresowania".',
		implode(
			"\n",
			array(
				'Wykonaj zadanie jako plan zwiedzania:',
				'1. Wyciągnij z artykułu główny motyw projektowy lub historyczny, który powinien stać się osią spaceru.',
				'2. Zaproponuj fragment Krakowa lub typ okolicy, od którego warto zacząć zwiedzanie w duchu tego artykułu.',
				'3. Ułóż krótką ścieżkę odkrywania miasta z 4-6 punktami: co zobaczyć, na jakie detale zwrócić uwagę i dlaczego to pasuje do tematu wpisu.',
				'4. Dodaj rekomendacje praktyczne: gdzie napić się kawy i zjeść ciastko, gdzie kupić pamiątkę lub obiekt związany z designem, oraz gdzie zjeść obiad, cały czas utrzymując motyw designu w tle.',
				'5. Dodaj 1 kolejny artykuł z Design History Forum, który naturalnie rozwija tę trasę.',
				'6. Jeśli nie masz pewności co do konkretnych adresów lub partnerów, nie zmyślaj nazw. Zamiast tego opisz typ miejsca, atmosferę i uzasadnij wybór.',
			)
		),
		implode(
			"\n",
			array(
				'Sformatuj odpowiedź w Markdown w pięciu sekcjach:',
				'Design Route: 1 krótki akapit, jaki jest motyw spaceru i dla kogo jest ta trasa.',
				'City Fragment: wskaż część miasta albo typ miejsca, od którego warto zacząć.',
				'What To See: lista punktów spaceru z krótkim komentarzem kuratorskim.',
				'Where To Stop: trzy podsekcje: coffee & cake, souvenir / design object, lunch.',
				'Next Step: 1 kolejny artykuł DHF i 1 krótkie uzasadnienie, dlaczego warto czytać dalej.',
			)
		),
		'Odpowiadaj w tonie entuzjastycznym, profesjonalnym, miejskim i konkretnym. Bądź bezpośredni i unikaj lania wody.',
		'Nie zmyślaj cytatów ani faktów spoza materiału źródłowego. Jeśli coś wnioskujesz, oznacz to jako interpretację.',
		'Odpowiedz w tym samym języku co artykuł, chyba że użytkownik poprosi inaczej.',
	);

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
	$prompt_url = rawurlencode( $prompt );
	$icons_base = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/images/ai-icons/';

	$rendered_posts[] = $post_id;

	$ai_tools = array(
		array(
			'label' => 'ChatGPT',
			'icon'  => $icons_base . 'gpt.svg',
			'url'   => 'https://chatgpt.com/?hints=search&prompt=' . $prompt_url,
		),
		array(
			'label' => 'Claude',
			'icon'  => $icons_base . 'claude.svg',
			'url'   => 'https://claude.ai/new?q=' . $prompt_url,
		),
		array(
			'label' => 'Gemini',
			'icon'  => $icons_base . 'gemini.svg',
			'url'   => 'https://gemini.google.com/app',
		),
		array(
			'label' => 'Perplexity',
			'icon'  => $icons_base . 'perplexity.svg',
			'url'   => 'https://www.perplexity.ai/search/new?q=' . $prompt_url,
		),
		array(
			'label' => 'Grok',
			'icon'  => $icons_base . 'grok.svg',
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
			<p class="dhf-article-tools__label">Zaplanuj z AI:</p>
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
						<span class="dhf-article-tools__badge" aria-hidden="true">
							<img
								class="dhf-article-tools__icon"
								src="<?php echo esc_url( $tool['icon'] ); ?>"
								alt=""
								loading="lazy"
								decoding="async"
							/>
						</span>
						<span class="screen-reader-text"><?php echo esc_html( $tool['label'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
			<p class="dhf-article-tools__hint">Kliknij ikonę, aby otworzyć AI z gotowym zadaniem: stwórz trasę zwiedzania inspirowaną tym artykułem i podpowiedz, co zobaczyć, gdzie napić się kawy, kupić pamiątkę i zjeść obiad. Jeśli pole promptu nie uzupełni się samo, użyj Ctrl+V.</p>
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
