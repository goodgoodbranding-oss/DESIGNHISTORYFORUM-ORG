## 2024-05-24 - [N+1 Query Bottleneck in Taxonomies]
**Learning:** `wp_get_post_terms` bypasses the object cache and queries the database directly, causing N+1 query bottlenecks.
**Action:** Always use `get_the_terms()` combined with `wp_list_pluck()` to leverage the object cache for post taxonomy queries.
