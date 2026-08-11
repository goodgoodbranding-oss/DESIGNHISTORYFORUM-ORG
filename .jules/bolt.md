## 2024-08-11 - Taxonomy Query Optimization
**Learning:** `wp_get_post_terms()` bypasses the object cache, which can lead to N+1 database queries when called multiple times on pages like archives or when building prompts.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` to retrieve term fields, as it properly leverages the WordPress object cache.
