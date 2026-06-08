## 2024-06-08 - Layout Thrashing in High-Frequency Events
**Learning:** Calling `getBoundingClientRect()` inside a `pointermove` event handler causes significant layout thrashing because it forces the browser to recalculate layout synchronously during every frame of a continuous pointer movement.
**Action:** Cache the bounding rectangle on `pointerenter` and use the cached value in `pointermove`, clearing it on `pointerleave`. Only call `getBoundingClientRect()` during continuous events if absolutely necessary and debounced.
