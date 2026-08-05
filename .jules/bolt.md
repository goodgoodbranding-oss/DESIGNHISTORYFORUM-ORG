## 2026-08-05 - Optimize Taxonomy Queries
**Learning:** wp_get_post_terms() bypasses the object cache and causes N+1 database query bottlenecks.
**Action:** Use get_the_terms() combined with wp_list_pluck() to leverage the object cache for taxonomy queries in this codebase.
