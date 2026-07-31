## 2024-05-15 - Avoid N+1 Queries in WordPress Taxonomies
**Learning:** Using `wp_get_post_terms` bypasses the object cache and can cause N+1 database queries.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` to leverage the object cache and prevent N+1 database query bottlenecks.
