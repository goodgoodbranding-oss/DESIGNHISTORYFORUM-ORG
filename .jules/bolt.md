## 2024-10-26 - Taxonomy query performance bottleneck
**Learning:** `wp_get_post_terms()` bypasses the WordPress object cache and causes N+1 database queries when fetching taxonomies, whereas `get_the_terms()` uses the cache.
**Action:** In WordPress taxonomy queries, always use `get_the_terms()` combined with `wp_list_pluck()` instead of `wp_get_post_terms()` to prevent bottlenecks.
