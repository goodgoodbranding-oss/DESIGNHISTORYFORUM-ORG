## 2024-06-17 - O(N) regex text processing on full strings vs trimmed chunks
**Learning:** In PHP, `preg_replace` and complex text normalization like `html_entity_decode` over long strings is expensive. In `functions.php`, doing this on the whole post content *before* `wp_trim_words()` applied an expensive O(N) operation to potentially thousands of words, just to use the first 220 words.
**Action:** When a smaller subset of a string is required via `wp_trim_words` (or `substr`, etc.), trim the raw HTML first before running expensive plain-text normalization operations on the smaller subset (O(M)).

## 2024-06-17 - Repeated function calls in loops
**Learning:** `dhf_normalize_prompt_text` fetches the global charset via `get_bloginfo('charset')`. Since this string normalization function is called multiple times (e.g. for every subheading via `dhf_extract_article_headings`), repeatedly calling `get_bloginfo()` introduces small but unnecessary overhead.
**Action:** Always statically cache constant global values (like `charset`) using `static $var = null;` when used in utility functions that may be called in loops.
