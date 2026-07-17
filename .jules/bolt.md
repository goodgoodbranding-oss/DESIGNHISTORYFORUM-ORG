## 2026-07-17 - WordPress Taxonomy Caching Bottleneck
**Learning:** wp_get_post_terms() bypasses the WordPress object cache and directly queries the database, leading to N+1 query bottlenecks.
**Action:** Always use get_the_terms() combined with wp_list_pluck() instead of wp_get_post_terms() for fetching taxonomy names to leverage caching.
