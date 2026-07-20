## 2024-05-24 - Prevent N+1 Taxonomy Queries
**Learning:** `wp_get_post_terms()` bypasses the WordPress object cache and causes N+1 database queries.
**Action:** Always use `get_the_terms()` followed by `wp_list_pluck()` to leverage the object cache when retrieving terms from a single post.
