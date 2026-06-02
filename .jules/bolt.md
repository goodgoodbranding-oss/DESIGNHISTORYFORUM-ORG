## 2024-05-18 - Avoid double string normalization on long text fields
**Learning:** In PHP, running complex regex patterns and HTML entity decodes on long text (like full blog articles) repeatedly is a performance pitfall. We found `dhf_normalize_prompt_text` being run twice on `$content` during prompt generation.
**Action:** Store the result of string normalization functions in a variable if they need to be used multiple times for the same input, and cache slow WP functions like `get_bloginfo` statically when they are called repeatedly within loops or text parsers.
