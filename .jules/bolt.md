
## 2024-05-30 - Taxonomy Query Bottlenecks
**Learning:** In WordPress taxonomy queries for this codebase, `wp_get_post_terms()` can lead to N+1 database query bottlenecks because it may bypass the object cache compared to simpler taxonomy functions.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` instead to leverage the object cache and prevent performance regressions.
