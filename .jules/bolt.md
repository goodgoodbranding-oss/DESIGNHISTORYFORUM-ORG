## 2024-05-28 - [Cache Taxonomy Queries]
**Learning:** `wp_get_post_terms()` bypasses the object cache and can cause N+1 database query bottlenecks when retrieving taxonomy terms for posts in loops or APIs.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck( ..., 'name' )` to fetch terms from the object cache instead.
