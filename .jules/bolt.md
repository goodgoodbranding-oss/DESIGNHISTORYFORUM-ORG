## 2024-07-26 - Layout Thrashing in Pointer Events
**Learning:** Frequent pointer events (`pointermove`) calling `getBoundingClientRect()` cause synchronous layout recalculations (layout thrashing), blocking the main thread.
**Action:** Cache static bounding boxes on `pointerenter` and invalidate them on `pointerleave` or `resize` to prevent unnecessary reflows during high-frequency events.
