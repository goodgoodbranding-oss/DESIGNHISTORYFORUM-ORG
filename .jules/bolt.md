## 2024-07-25 - [Object Cache for Taxonomy Queries]
**Learning:** In WordPress, `wp_get_post_terms()` with `fields => names` bypasses the object cache and executes direct database queries, leading to N+1 query bottlenecks when used in loops or for multiple posts.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` to retrieve term names, as `get_the_terms()` utilizes the WordPress object cache effectively.
