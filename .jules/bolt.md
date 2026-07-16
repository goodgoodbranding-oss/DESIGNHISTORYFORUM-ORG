## 2024-05-23 - Prevent N+1 Taxonomy Queries
**Learning:** wp_get_post_terms() bypasses the object cache and queries the database directly. In loops, this causes an N+1 query performance bottleneck.
**Action:** Use get_the_terms() combined with wp_list_pluck() instead when querying taxonomy terms by name to leverage caching.
