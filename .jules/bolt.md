## 2024-07-22 - [WordPress N+1 Taxonomy Queries]
**Learning:** [wp_get_post_terms does not use the WordPress object cache, which can lead to N+1 query bottlenecks when called in loops or hooks.]
**Action:** [Always use get_the_terms() combined with wp_list_pluck() for taxonomy queries to leverage caching and prevent performance degradation.]
