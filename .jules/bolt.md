## 2024-05-24 - N+1 Taxonomy Query Bottlenecks
**Learning:** `wp_get_post_terms()` can bypass the object cache in WordPress, leading to N+1 query bottlenecks when retrieving taxonomy terms.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead of `wp_get_post_terms()` to leverage the object cache and prevent database query bottlenecks.
