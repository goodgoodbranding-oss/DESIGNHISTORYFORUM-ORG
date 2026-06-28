## 2024-06-28 - Cache getBoundingClientRect in mousemove events
**Learning:** Calling `getBoundingClientRect()` synchronously in a `pointermove` event handler causes layout thrashing, especially when combined with inline style updates in `requestAnimationFrame`.
**Action:** Cache the bounding rectangle calculation on `pointerenter` (or resize) and reuse it in `pointermove` instead of calling `getBoundingClientRect()` on every move event.
