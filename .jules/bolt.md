## 2026-07-11 - Optimize Database Query for Post Terms
**Learning:** `wp_get_post_terms()` ignores WordPress's internal object cache and always forces a direct database query. This can lead to N+1 query problems when rendering content loops or preparing data for prompts.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` to extract specific fields like names. `get_the_terms()` hits the object cache first, making it significantly faster for retrieving post metadata without triggering redundant queries.
