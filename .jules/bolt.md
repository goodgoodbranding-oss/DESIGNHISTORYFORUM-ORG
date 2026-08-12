## 2024-08-11 - Optimize Taxonomy Queries
**Learning:** Using wp_get_post_terms() triggers direct DB queries (N+1 issue), whereas get_the_terms() utilizes the object cache.
**Action:** Always prefer get_the_terms() followed by wp_list_pluck() for taxonomy data retrieval in loops or frequent calls to improve performance.
