## 2024-05-24 - Layout Thrashing in pointermove
**Learning:** Calling `getBoundingClientRect()` on every `pointermove` event causes severe layout thrashing (synchronous layout reflows), degrading scroll and animation performance drastically because `pointermove` fires continuously.
**Action:** Always cache the `DOMRect` on `pointerenter` (or `mouseenter`) and invalidate it on `pointerleave` and `resize` when mapping pointer coordinates to a container's bounds.
