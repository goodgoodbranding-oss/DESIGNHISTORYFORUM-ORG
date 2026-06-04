
## 2024-06-04 - Cache Layout Information to Prevent Layout Thrashing
**Learning:** Found a layout thrashing bottleneck in `homepage-cards.js` where `getBoundingClientRect()` was being called on every `pointermove` event while `requestAnimationFrame` was concurrently updating CSS custom properties (triggering a repaint). Reading layout immediately after writing styles within rapid-fire events leads to forced synchronous layouts, heavily impacting scroll and animation performance.
**Action:** Always cache bounding box coordinates during initial `pointerenter` and invalidate them on `pointerleave` or `resize` instead of fetching them on every move.
