## 2024-06-29 - Cache normalized content to avoid duplicate regex on full article body
**Learning:** In WordPress data extraction flows, running expensive text processing (regex, strip tags) on full HTML article bodies repeatedly (e.g., for lead and body extraction) creates unnecessary CPU load.
**Action:** Always cache the result of expensive string transformations like `dhf_normalize_prompt_text()` when the source text (`$content`) will be used multiple times in the same function.
