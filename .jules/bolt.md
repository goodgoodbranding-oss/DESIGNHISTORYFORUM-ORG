## 2024-07-23 - Prevent N+1 queries with taxonomy terms
**Learning:** Using wp_get_post_terms() bypasses the WordPress object cache and causes N+1 database queries.
**Action:** Use get_the_terms() combined with wp_list_pluck() instead to leverage the object cache for better performance.
