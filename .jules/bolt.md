## 2024-06-20 - Prevent Layout Thrashing in Pointer Events
**Learning:** DOM measurements like `getBoundingClientRect()` in high-frequency events (e.g., `pointermove`) cause layout thrashing and significant client-side performance bottlenecks (dropped frames during animation).
**Action:** Always cache bounding rectangle dimensions for continuous events and clear the cache when the element leaves hover, or when the window is resized or scrolled. Also mark such event listeners as `passive: true`.
