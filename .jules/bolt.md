## 2024-08-07 - Optimize taxonomy queries
**Learning:** In WordPress, `wp_get_post_terms()` bypasses the object cache and queries the database directly, leading to N+1 queries in loops.
**Action:** Use `get_the_terms()` which uses the object cache, combined with `wp_list_pluck()` to extract specific fields like names.
