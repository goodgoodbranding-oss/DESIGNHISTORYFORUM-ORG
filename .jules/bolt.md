## 2024-10-25 - Fix Layout Thrashing on Pointer Move
**Learning:** Calling `getBoundingClientRect()` inside a high-frequency event listener like `pointermove` forces synchronous layout recalculations, causing frame drops and poor frontend performance.
**Action:** When calculating elements related to cursor position on events like `pointermove` or `mousemove`, cache the `getBoundingClientRect()` values on `pointerenter` and recalculate them on `resize`, rather than calling `getBoundingClientRect()` on every single pointer movement.
