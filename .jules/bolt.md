## 2024-05-17 - Caching DOM Rect Layout Reads During Pointer Events
**Learning:** Calling `getBoundingClientRect()` within a high-frequency event like `pointermove` forces a synchronous layout read. If there is a concurrent `requestAnimationFrame` loop modifying CSS custom properties or anything else that invalidates layout, it creates layout thrashing and drops frame rates severely.
**Action:** Always cache bounding boxes (`getBoundingClientRect`) on `pointerenter` and `resize` events if they are needed during a `pointermove` or `mousemove` callback that writes to the DOM.
