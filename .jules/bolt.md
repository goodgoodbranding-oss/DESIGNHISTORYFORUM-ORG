## 2024-08-06 - Replace wp_get_post_terms with get_the_terms for object cache
**Learning:** `wp_get_post_terms()` bypasses the WordPress object cache and forces a database query every time, leading to N+1 query bottlenecks on pages with multiple posts. `get_the_terms()` utilizes the object cache and is much more performant.
**Action:** In WordPress taxonomy queries for this codebase, always use `get_the_terms()` combined with `wp_list_pluck()` instead of `wp_get_post_terms()` to extract specific fields like names and avoid N+1 queries.
