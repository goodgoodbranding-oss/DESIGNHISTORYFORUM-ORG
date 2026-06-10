## 2024-05-24 - Layout Thrashing in High-Frequency Pointer Events
**Learning:** Calling `getBoundingClientRect()` inside a high-frequency event listener like `pointermove`, especially when followed by DOM writes (like updating CSS variables in `requestAnimationFrame`), creates severe layout thrashing (forced synchronous layouts).
**Action:** Always cache layout geometry (like `left` and `width`) on `pointerenter` and invalidate it on `pointerleave` or `resize` instead of reading it on every `pointermove`.
