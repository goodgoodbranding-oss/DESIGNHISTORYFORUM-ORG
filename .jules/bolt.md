## 2024-08-09 - Object caching for taxonomy queries
**Learning:** In WordPress taxonomy queries for this codebase, `wp_get_post_terms()` misses the object cache, causing N+1 database query bottlenecks.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead of `wp_get_post_terms()` to leverage the object cache and prevent N+1 database query bottlenecks.
