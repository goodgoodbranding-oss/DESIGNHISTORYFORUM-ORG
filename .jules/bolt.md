## 2024-05-24 - N+1 Taxonomy Query Bottleneck
**Learning:** wp_get_post_terms bypasses the object cache causing N+1 query bottlenecks in WordPress.
**Action:** Use get_the_terms() combined with wp_list_pluck() instead to leverage the object cache for retrieving term names.
