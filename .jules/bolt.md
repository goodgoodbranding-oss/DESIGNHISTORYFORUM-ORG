## 2024-08-02 - Replace wp_get_post_terms with get_the_terms
**Learning:** Using `wp_get_post_terms()` bypasses the object cache and queries the database directly, leading to N+1 query bottlenecks in loops or multiple calls.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` in WordPress taxonomy queries to leverage the object cache and prevent N+1 database query bottlenecks.
