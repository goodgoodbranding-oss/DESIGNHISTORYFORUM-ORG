## 2024-05-19 - Avoid Layout Thrashing in High-Frequency Events
**Learning:** Calling `getBoundingClientRect()` synchronously inside high-frequency event handlers like `pointermove` can cause layout thrashing and negatively impact frontend performance. The browser is forced to recalculate the layout repeatedly.
**Action:** When working with high-frequency events, cache bounding rectangles at appropriate times (like on `pointerenter`) and reuse the cached value. Clear the cache when the element is no longer being interacted with (like on `pointerleave`).
