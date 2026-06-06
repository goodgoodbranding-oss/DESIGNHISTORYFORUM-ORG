## 2024-05-24 - Layout Thrashing in Hover Interactions
**Learning:** Calling `getBoundingClientRect()` inside a `pointermove` event handler, while simultaneously updating CSS custom properties (variables) via `requestAnimationFrame` in the same element's tree, forces synchronous layout recalculation (layout thrashing).
**Action:** Always cache bounding rects on `pointerenter` (and clear on `pointerleave`/`resize`) rather than querying them on every `pointermove` when calculating proximity or interactive styles.
