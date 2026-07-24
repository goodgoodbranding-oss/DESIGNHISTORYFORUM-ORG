## 2024-07-24 - Optimize WordPress Taxonomy Queries
**Learning:** `wp_get_post_terms()` bypasses the object cache and results in N+1 database query bottlenecks when called in loops or frequently accessed contexts.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead to leverage the WordPress object cache for improved backend performance.
