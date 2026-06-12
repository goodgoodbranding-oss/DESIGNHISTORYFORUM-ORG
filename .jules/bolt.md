## 2024-06-12 - Layout thrashing in pointermove handlers
**Learning:** `getBoundingClientRect()` forces synchronous layout when called continuously within a `pointermove` handler, especially if the loop is also modifying CSS custom properties (like the homepage cards effect).
**Action:** Always cache bounding box dimensions on `pointerenter` for interactions constrained to an element boundary, and reuse the cache during `pointermove` to keep the animation smooth.
