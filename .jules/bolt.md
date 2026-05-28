## 2026-05-28 - Cache layout measurements on pointer events
**Learning:** Found layout thrashing due to continuous `getBoundingClientRect()` calls inside a `pointermove` event on the homepage hero area. In highly interactive UI components driven by mouse coordinates, recalculating the layout inside `requestAnimationFrame` or high-frequency events causes main thread blocking.
**Action:** Always cache bounding boxes on `pointerenter` and clear them on `pointerleave` or `window.resize` rather than querying the DOM on every move.
