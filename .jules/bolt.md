## 2024-07-13 - Replace wp_get_post_terms with get_the_terms
**Learning:** `wp_get_post_terms()` queries the database directly and does not use the WordPress object cache, which can cause N+1 query performance bottlenecks when called multiple times or inside loops.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead to leverage the WordPress object cache for taxonomy queries.
