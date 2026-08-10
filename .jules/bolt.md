## 2024-05-27 - N+1 Queries in Taxonomy Lookups
**Learning:** Using `wp_get_post_terms()` with specific `fields` arguments bypasses the WordPress object cache, leading to N+1 database query bottlenecks when retrieving categories and tags during content generation.
**Action:** Always use `get_the_terms()` combined with `wp_list_pluck()` to retrieve term fields to correctly leverage the WP object cache.
