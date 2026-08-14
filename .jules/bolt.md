## 2024-05-18 - Optimize taxonomy queries and text normalization
**Learning:** Using `wp_get_post_terms()` causes N+1 queries, while `get_the_terms()` combined with `wp_list_pluck()` uses the object cache effectively. Also, text normalization in WordPress requires `strip_shortcodes()` before applying `wp_strip_all_tags` and `wp_trim_words` to prevent data malformation.
**Action:** Always prefer `get_the_terms()` for taxonomies in loops or single contexts, and apply `strip_shortcodes()` first when stripping content.
