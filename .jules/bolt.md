## 2026-06-18 - Prevent Layout Thrashing in `pointermove` Event
**Learning:** Calling `getBoundingClientRect()` within a high-frequency event listener like `pointermove` forces synchronous layout recalculation on every mouse move, which can cause severe layout thrashing and drop frame rates.
**Action:** Cache the bounding box details on `pointerenter` (and clear on `pointerleave`) to perform math operations using cached dimensions during the `pointermove` event instead of repeatedly querying the DOM.
