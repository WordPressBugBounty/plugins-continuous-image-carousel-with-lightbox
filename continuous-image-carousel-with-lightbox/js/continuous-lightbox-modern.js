/**
 * Continuous Image Carousel With Lightbox — modern lightbox
 * Dependency-free replacement for the vendored FancyBox 1.3.6 fork.
 * Opt-in via the "Lightbox Engine" setting; legacy engine is untouched.
 */
(function () {
    'use strict';

    var overlay, imgEl, captionEl, closeBtn, prevBtn, nextBtn;
    var currentGroup = [];
    var currentIndex = 0;
    var lastFocused = null;

    function buildOverlay() {
        if (overlay) {
            return;
        }
        overlay = document.createElement('div');
        overlay.className = 'cicwl-modern-lightbox-overlay';
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');
        overlay.innerHTML =
            '<button type="button" class="cicwl-modern-lightbox-close" aria-label="Close">&times;</button>' +
            '<button type="button" class="cicwl-modern-lightbox-prev" aria-label="Previous image">&#10094;</button>' +
            '<div class="cicwl-modern-lightbox-stage">' +
                '<img class="cicwl-modern-lightbox-img" alt="" />' +
                '<div class="cicwl-modern-lightbox-caption"></div>' +
            '</div>' +
            '<button type="button" class="cicwl-modern-lightbox-next" aria-label="Next image">&#10095;</button>';
        document.body.appendChild(overlay);

        imgEl = overlay.querySelector('.cicwl-modern-lightbox-img');
        captionEl = overlay.querySelector('.cicwl-modern-lightbox-caption');
        closeBtn = overlay.querySelector('.cicwl-modern-lightbox-close');
        prevBtn = overlay.querySelector('.cicwl-modern-lightbox-prev');
        nextBtn = overlay.querySelector('.cicwl-modern-lightbox-next');

        closeBtn.addEventListener('click', close);
        prevBtn.addEventListener('click', function () { show(currentIndex - 1); });
        nextBtn.addEventListener('click', function () { show(currentIndex + 1); });
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                close();
            }
        });

        var touchStartX = null;
        overlay.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].clientX;
        }, { passive: true });
        overlay.addEventListener('touchend', function (e) {
            if (touchStartX === null) {
                return;
            }
            var dx = e.changedTouches[0].clientX - touchStartX;
            if (Math.abs(dx) > 40) {
                dx < 0 ? show(currentIndex + 1) : show(currentIndex - 1);
            }
            touchStartX = null;
        }, { passive: true });
    }

    function show(index) {
        if (!currentGroup.length) {
            return;
        }
        currentIndex = (index + currentGroup.length) % currentGroup.length;
        var item = currentGroup[currentIndex];
        imgEl.src = item.src;
        imgEl.alt = item.caption || '';
        captionEl.innerHTML = item.caption || '';
        captionEl.style.display = item.caption ? '' : 'none';
        var multi = currentGroup.length > 1;
        prevBtn.style.display = multi ? '' : 'none';
        nextBtn.style.display = multi ? '' : 'none';
    }

    function open(group, index) {
        buildOverlay();
        currentGroup = group;
        lastFocused = document.activeElement;
        show(index);
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        closeBtn.focus();
        document.addEventListener('keydown', onKeydown);
    }

    function close() {
        if (!overlay) {
            return;
        }
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
        document.removeEventListener('keydown', onKeydown);
        if (lastFocused && lastFocused.focus) {
            lastFocused.focus();
        }
    }

    function onKeydown(e) {
        if (e.key === 'Escape') {
            close();
            return;
        }
        if (e.key === 'ArrowLeft') {
            show(currentIndex - 1);
            return;
        }
        if (e.key === 'ArrowRight') {
            show(currentIndex + 1);
            return;
        }
        if (e.key === 'Tab') {
            var focusable = [closeBtn, prevBtn, nextBtn];
            var idx = focusable.indexOf(document.activeElement);
            e.preventDefault();
            if (e.shiftKey) {
                focusable[idx <= 0 ? focusable.length - 1 : idx - 1].focus();
            } else {
                focusable[idx === focusable.length - 1 ? 0 : idx + 1].focus();
            }
        }
    }

    function collectGroup(trigger) {
        var container = (trigger.closest && trigger.closest('.cicwl-slider-wrap')) || document;
        var rel = trigger.getAttribute('rel');
        var nodes = Array.prototype.slice.call(container.querySelectorAll('[data-cicwl-lightbox-src]'));
        var seen = {};
        var group = [];
        nodes.forEach(function (node) {
            if (rel && node.getAttribute('rel') !== rel) {
                return;
            }
            var src = node.getAttribute('data-cicwl-lightbox-src');
            // The modern carousel clones its item set for a seamless loop —
            // de-duplicate so each image appears once in the lightbox group.
            if (seen[src]) {
                return;
            }
            seen[src] = true;
            group.push({
                src: src,
                caption: node.getAttribute('data-cicwl-lightbox-caption') || ''
            });
        });
        return group;
    }

    document.addEventListener('click', function (e) {
        var trigger = e.target.closest && e.target.closest('[data-cicwl-lightbox-src]');
        if (!trigger) {
            return;
        }
        e.preventDefault();
        var group = collectGroup(trigger);
        var src = trigger.getAttribute('data-cicwl-lightbox-src');
        var index = -1;
        for (var i = 0; i < group.length; i++) {
            if (group[i].src === src) {
                index = i;
                break;
            }
        }
        open(group, index < 0 ? 0 : index);
    });
})();
