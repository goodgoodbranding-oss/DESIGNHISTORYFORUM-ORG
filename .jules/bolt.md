## 2024-08-01 - Object Caching with Taxonomy Queries
**Learning:** In this WordPress codebase, using `wp_get_post_terms()` avoids the object cache and leads to N+1 database queries.
**Action:** Always use `get_the_terms()` combined with `wp_list_pluck()` to leverage the object cache and prevent N+1 query bottlenecks.
