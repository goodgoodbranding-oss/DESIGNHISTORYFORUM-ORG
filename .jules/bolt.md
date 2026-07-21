## 2024-07-21 - WordPress Taxonomy Object Caching
**Learning:** Using `wp_get_post_terms` bypasses the object cache by default for specific fields, leading to N+1 queries in loops.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead of `wp_get_post_terms()` to leverage the object cache and prevent database query bottlenecks in WordPress taxonomy queries.
