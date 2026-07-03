## 2024-05-24 - Layout Thrashing in requestAnimationFrame
**Learning:** Calling `getBoundingClientRect()` inside a mouse/pointer event handler (like `pointermove`) that runs concurrently with a `requestAnimationFrame` loop modifying styles causes severe layout thrashing (forced synchronous layout). The browser has to recalculate layout repeatedly because the DOM is modified and then immediately measured.
**Action:** Always cache bounding boxes (like `getBoundingClientRect()`) on `pointerenter`/`mouseenter` and reuse the cached values during `pointermove`. Clear the cache on `pointerleave`.
