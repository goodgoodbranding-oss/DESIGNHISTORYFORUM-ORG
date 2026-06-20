## 2024-06-20 - Layout Thrashing in pointermove Animation
**Learning:** Querying `getBoundingClientRect()` inside a `pointermove` handler while simultaneously updating CSS custom properties (and triggering layout changes) causes severe layout thrashing and negatively impacts performance.
**Action:** Cache the dimensions of the element (e.g. `cachedCenterX`, `cachedHalfWidth`) either on initialization, on `pointerenter`, or on resize, and clear the cache when the interaction finishes (`pointerleave`), avoiding querying the DOM for dimensions during the high-frequency `pointermove` event.
