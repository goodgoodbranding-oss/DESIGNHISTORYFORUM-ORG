## 2026-06-09 - Caching Layout Measurements to Prevent Thrashing
**Learning:** Combining `getBoundingClientRect()` on `pointermove` with `requestAnimationFrame` that mutates styles causes significant layout thrashing. Because styles are modified asynchronously, calling `getBoundingClientRect()` inside the high-frequency `pointermove` event forces synchronous layout recalculations continually.
**Action:** Always cache bounding rects on `pointerenter` and clear them on `pointerleave` when tracking mouse movement over an element, rather than measuring layout on every single `pointermove` event.
