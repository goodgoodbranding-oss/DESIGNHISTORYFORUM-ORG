## 2025-01-20 - N+1 Query Prevention in Taxonomy Retrieval
**Learning:** `wp_get_post_terms()` bypasses the WordPress object cache and queries the database directly, which creates an N+1 query bottleneck if called repeatedly (e.g., in a filter for `the_content` on archive pages).
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` when querying taxonomy fields like `names` to leverage the WordPress object cache and prevent database query scaling issues.
