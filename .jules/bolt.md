## 2024-08-04 - Optimize taxonomy terms retrieval
**Learning:** Using `wp_get_post_terms()` bypasses the WordPress object cache, leading to N+1 database query bottlenecks when retrieving terms for multiple posts.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead to retrieve terms efficiently utilizing object caching.
