## 2024-05-20 - Prevent N+1 queries in taxonomy lookups
**Learning:** Using `wp_get_post_terms` can bypass object cache, leading to N+1 database query bottlenecks.
**Action:** Always use `get_the_terms()` combined with `wp_list_pluck()` in WordPress taxonomy queries for this codebase to leverage the object cache.
