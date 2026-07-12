## 2024-07-12 - Object Cache for Taxonomy Queries
**Learning:** Using `wp_get_post_terms()` with specific fields bypasses the object cache, causing N+1 database query bottlenecks.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead of `wp_get_post_terms()` in WordPress taxonomy queries to leverage the object cache.
