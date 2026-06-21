## 2024-05-24 - Layout Thrashing in High-Frequency Events
**Learning:** Calling `getBoundingClientRect()` inside a `pointermove` event handler causes synchronous layout reads on the main thread, leading to high CPU usage even if it doesn't force a full reflow.
**Action:** Cache static layout values (like the bounding box of a fixed-size element) when the pointer enters the area (`pointerenter`) instead of computing them continuously during `pointermove`.
