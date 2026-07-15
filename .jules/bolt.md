## 2026-07-15 - Cached taxonomy queries in WordPress
**Learning:** In WordPress, `wp_get_post_terms()` always queries the database directly, bypassing the object cache. This can cause N+1 query bottlenecks.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead to retrieve taxonomy terms from the object cache, preventing redundant database queries.