## 2024-06-25 - Avoid getBoundingClientRect in pointermove
**Learning:** Calling `getBoundingClientRect()` inside a highly frequent event listener like `pointermove` forces the browser to synchronously recalculate layout (layout thrashing) up to 60 times a second, which causes massive jank.
**Action:** Always cache bounding rects on `pointerenter` (or similar low-frequency events) and clear the cache on `pointerleave` or window resize, so the frequent `pointermove` event only does fast math.
