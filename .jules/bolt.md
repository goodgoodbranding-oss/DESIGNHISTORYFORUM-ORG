## 2023-10-25 - Object Cache Bypass in Taxonomy Queries
**Learning:** `wp_get_post_terms` bypasses the WordPress object cache causing N+1 database query bottlenecks when retrieving taxonomy terms in loops.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead to leverage caching.
