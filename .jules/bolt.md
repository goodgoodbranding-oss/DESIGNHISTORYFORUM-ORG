## 2024-08-14 - Initialization
**Learning:** Initialized Bolt journal.
**Action:** Always check this file for codebase-specific learnings.


## 2024-08-14 - Use get_the_terms for taxonomy query caching
**Learning:** `wp_get_post_terms()` directly queries the database without leveraging the object cache, causing N+1 DB queries when processing terms on multiple posts.
**Action:** Use `get_the_terms()` combined with `wp_list_pluck()` to leverage WP object caching and improve taxonomy retrieval performance.
