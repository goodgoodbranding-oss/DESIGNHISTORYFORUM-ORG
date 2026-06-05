## 2024-06-05 - Avoid layout thrashing in pointer events
**Learning:** Found an anti-pattern in `homepage-cards.js` where `getBoundingClientRect()` was called repeatedly inside a `pointermove` event listener. Reading layout properties after writing styles in an animation frame causes synchronous layout calculation (layout thrashing).
**Action:** Always cache bounding rects for static elements instead of calculating them on every mouse/pointer move, and invalidate the cache only on resize or pointerenter to maintain high framerate animations.
