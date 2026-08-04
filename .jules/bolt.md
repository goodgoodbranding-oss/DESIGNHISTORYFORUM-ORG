## 2026-08-04 - Object cache bypassed by wp_get_post_terms()
**Learning:** In WordPress taxonomy queries for this codebase, `wp_get_post_terms()` bypasses the object cache when requesting specific fields like 'names', leading to N+1 database queries.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` to fetch all term objects (which are cached) and then extract the required field in PHP.
