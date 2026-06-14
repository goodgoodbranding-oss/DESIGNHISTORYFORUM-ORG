## 2024-06-14 - Prevent Layout Thrashing in Pointer Events
**Learning:** Calling `getBoundingClientRect()` inside high-frequency event listeners like `pointermove` forces synchronous layout calculation, leading to layout thrashing and dropped frames.
**Action:** Cache the layout metrics during `pointerenter` or initial calculation, and clear the cache on `pointerleave` or resize to maintain performance without sacrificing correctness.
