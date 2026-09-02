/**
 * Continuous Image Carousel With Lightbox — modern engine
 * Dependency-free replacement for the bxSlider-based ticker.
 * Opt-in via the "Slider Engine" setting; legacy engine is untouched.
 */
(function () {
    'use strict';

    function initCarousel(el) {
        if (el.getAttribute('data-cicwl-initialized') === '1') {
            return;
        }
        el.setAttribute('data-cicwl-initialized', '1');

        var items = Array.prototype.slice.call(el.children);
        if (!items.length) {
            return;
        }

        // Item styling is applied inline rather than via CSS class selectors
        // (e.g. ".limargin") so this same engine works unmodified across
        // plugins/markups that wrap each image differently.
        items.forEach(function (item) {
            item.style.flex = '0 0 auto';
            if (!item.style.display) {
                item.style.display = 'block';
            }
        });

        var showCaptions = el.getAttribute('data-cicwl-caption') === '1';
        var captionRadius = parseInt(el.getAttribute('data-cicwl-border-radius'), 10) || 0;
        if (showCaptions) {
            items.forEach(function (item) {
                var img = item.querySelector('img');
                var text = img ? img.getAttribute('title') : '';
                if (!text) {
                    return;
                }
                var caption = document.createElement('div');
                caption.className = 'cicwl-modern-caption';
                caption.textContent = text;
                if (captionRadius) {
                    caption.style.borderBottomLeftRadius = captionRadius + 'px';
                    caption.style.borderBottomRightRadius = captionRadius + 'px';
                }
                // Anchor the caption to the image's own immediate wrapper
                // (its <a>, typically) rather than the outer per-item
                // container — the outer wrapper can carry its own margin or
                // sizing that doesn't tightly hug the image, which pushed
                // the caption below/outside the actual picture instead of
                // overlaying its bottom edge.
                var host = img.parentElement || item;
                if (!host.style.display) {
                    host.style.display = 'block';
                }
                if (!host.style.position) {
                    host.style.position = 'relative';
                }
                host.appendChild(caption);

                // Without this, the image (and the caption bar drawn right
                // on top of it) sits flush against the item's own border
                // with zero gap, so the caption visually merges into the
                // border line instead of sitting clearly above it.
                if (!item.style.paddingBottom) {
                    item.style.paddingBottom = '3px';
                }
            });
        }

        // The wrapper starts as inline display:none (set server-side to avoid
        // a flash of unsized content). Reveal it via visibility instead of
        // display before doing any width math below — a display:none element
        // always measures 0 width, which previously made every "how wide is
        // this carousel" check silently fail.
        el.style.visibility = 'hidden';
        el.style.display = 'block';

        var track = document.createElement('div');
        track.className = 'cicwl-modern-track';
        el.innerHTML = '';
        el.appendChild(track);

        var speed = parseInt(el.getAttribute('data-cicwl-speed'), 10) || 15000;
        var margin = parseInt(el.getAttribute('data-cicwl-margin'), 10);
        var marginVal = isNaN(margin) ? 0 : margin;
        var pauseOnHover = el.getAttribute('data-cicwl-pause-hover') === '1';
        var bg = el.getAttribute('data-cicwl-bg');
        var visible = parseInt(el.getAttribute('data-cicwl-visible'), 10);
        var imagewidth = parseInt(el.getAttribute('data-cicwl-imagewidth'), 10);

        if (bg) {
            el.style.background = bg;
        }

        // "Max Visible" caps how wide the carousel window is, same intent as
        // the legacy engine's slideWidth * maxSlides. Without this the modern
        // engine just filled whatever width its parent happened to give it
        // (very wide in wp-admin), showing far more images at once than the
        // setting asked for.
        if (visible > 0 && imagewidth > 0) {
            var capWidth = (visible * imagewidth) + (Math.max(visible - 1, 0) * marginVal);
            el.style.width = capWidth + 'px';
            el.style.maxWidth = '100%';
        }

        // Pass 1: lay down one copy of the real items so we can measure how
        // wide a single set actually renders (image sizes vary per slider).
        items.forEach(function (item) {
            track.appendChild(item);
        });

        var containerWidth = el.clientWidth || el.getBoundingClientRect().width || 0;
        var singleSetWidth = track.scrollWidth || 1;

        // If a single set of images is narrower than the carousel window
        // (common with only 2-3 images, or a small Max Visible value), repeat
        // the set until it fills the container — otherwise the seamless loop
        // below would show an empty gap every pass instead of scrolling
        // straight from the last image back into the first.
        var repeats = 1;
        var safetyLimit = 25;
        while (containerWidth > 0 && singleSetWidth * repeats < containerWidth && repeats < safetyLimit) {
            items.forEach(function (item) {
                track.appendChild(item.cloneNode(true));
            });
            repeats++;
        }

        // Pass 2: duplicate the whole (now wide-enough) block once more.
        // Animating the track from translateX(0) to translateX(-50%) then
        // lands exactly back on an identical copy of the start — so the
        // last image flows straight into the first with no jump or pause,
        // regardless of how many images the slider has.
        var block = Array.prototype.slice.call(track.children);
        block.forEach(function (node) {
            track.appendChild(node.cloneNode(true));
        });

        if (marginVal) {
            Array.prototype.forEach.call(track.children, function (item) {
                item.style.marginRight = marginVal + 'px';
            });
        }

        // Scale duration by repeats so the on-screen scroll speed (px/sec)
        // stays consistent no matter how many times the set had to repeat
        // to fill the container.
        track.style.animationDuration = (speed * repeats) + 'ms';

        if (pauseOnHover) {
            el.addEventListener('mouseenter', function () {
                track.style.animationPlayState = 'paused';
            });
            el.addEventListener('mouseleave', function () {
                track.style.animationPlayState = 'running';
            });
        }

        el.style.visibility = '';

        // Pause the animation while scrolled off-screen to save CPU/battery.
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    track.style.animationPlayState = entry.isIntersecting ? 'running' : 'paused';
                });
            }, { threshold: 0 });
            io.observe(el);
        }
    }

    function initAll() {
        var carousels = document.querySelectorAll('.cicwl-engine-modern');
        Array.prototype.forEach.call(carousels, initCarousel);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})();
