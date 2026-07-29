## 2024-05-15 - [Object Cache Bypass Bottleneck in Taxonomy Queries]
**Learning:** `wp_get_post_terms` bypasses the object cache causing N+1 query problems.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead to leverage the object cache.
