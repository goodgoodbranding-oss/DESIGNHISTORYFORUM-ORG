## 2026-06-26 - Layout Thrashing in pointermove
**Learning:** Calling getBoundingClientRect() inside high-frequency events like pointermove forces synchronous style recalculation and layout thrashing, dropping frames significantly.
**Action:** Cache DOM measurements on pointerenter or similar triggers, use the cached values in the high-frequency event, and clear the cache on pointerleave and window resize.
