export function bindEvent(el, type, fn) {
    if (el && el.addEventListener) {
        el.addEventListener(type, fn, false);
    }
}