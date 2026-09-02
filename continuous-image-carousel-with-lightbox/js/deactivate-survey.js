/**
 * Continuous Image Carousel With Lightbox — deactivation survey.
 * Intercepts the Deactivate link for this plugin on the Plugins list page,
 * asks a quick "why", and — if the reason is a missing feature — shows a
 * short Pro pitch before letting the deactivation proceed. Never blocks
 * deactivation outright; "Skip & Deactivate" and the modal's close button
 * both let it through immediately.
 */
(function () {
    'use strict';

    var cfg = window.cicwlDeactivateSurvey;
    if (!cfg || !cfg.pluginBasename) {
        return;
    }

    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    function findDeactivateLink() {
        var encoded = encodeURIComponent(cfg.pluginBasename);
        var links = document.querySelectorAll('.deactivate a, .delete a');
        for (var i = 0; i < links.length; i++) {
            var href = links[i].getAttribute('href') || '';
            if (href.indexOf(encoded) !== -1 && href.indexOf('action=deactivate') !== -1) {
                return links[i];
            }
        }
        return null;
    }

    function submitFeedback(reason) {
        if (!cfg.ajaxUrl || !cfg.nonce) {
            return;
        }
        try {
            var body = new URLSearchParams();
            body.set('action', 'cicwl_deactivate_feedback');
            body.set('nonce', cfg.nonce);
            body.set('reason', reason);
            // Best-effort — never let a failed request delay deactivation.
            fetch(cfg.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' });
        } catch (e) {
            // ignore
        }
    }

    function buildModal(deactivateUrl) {
        var strings = cfg.strings || {};
        var overlay = document.createElement('div');
        overlay.className = 'cicwl-deactivate-overlay';

        var reasonKeys = ['missing_feature', 'found_bug', 'switching', 'temporary', 'other'];
        var reasonsHtml = '';
        reasonKeys.forEach(function (key, index) {
            var label = (strings.reasons && strings.reasons[key]) || key;
            reasonsHtml +=
                '<label class="cicwl-deactivate-reason">' +
                '<input type="radio" name="cicwl_deactivate_reason" value="' + key + '"' + (index === 0 ? '' : '') + '>' +
                '<span>' + label + '</span>' +
                '</label>';
        });

        overlay.innerHTML =
            '<div class="cicwl-deactivate-modal" role="dialog" aria-modal="true">' +
                '<h2>' + (strings.title || 'Quick question before you go') + '</h2>' +
                '<p class="cicwl-deactivate-subtitle">' + (strings.subtitle || '') + '</p>' +
                '<div class="cicwl-deactivate-reasons">' + reasonsHtml + '</div>' +
                '<div class="cicwl-deactivate-pro-pitch" hidden>' +
                    '<h3>' + (strings.proPitchTitle || '') + '</h3>' +
                    '<p>' + (strings.proPitchBody || '') + '</p>' +
                    '<a href="' + (cfg.proUrl || '#') + '" target="_blank" rel="noopener noreferrer" class="button button-primary cicwl-deactivate-pro-btn">' + (strings.proPitchButton || 'See Pro Features') + '</a>' +
                '</div>' +
                '<div class="cicwl-deactivate-actions">' +
                    '<button type="button" class="button cicwl-deactivate-cancel">' + (strings.cancel || 'Cancel') + '</button>' +
                    '<button type="button" class="button button-primary cicwl-deactivate-submit">' + (strings.submitAndDeactivate || 'Submit & Deactivate') + '</button>' +
                    '<a href="' + deactivateUrl + '" class="cicwl-deactivate-skip">' + (strings.skipAndDeactivate || 'Skip & Deactivate') + '</a>' +
                '</div>' +
            '</div>';

        document.body.appendChild(overlay);

        var proPitch = overlay.querySelector('.cicwl-deactivate-pro-pitch');
        var radios = overlay.querySelectorAll('input[name="cicwl_deactivate_reason"]');
        var submitBtn = overlay.querySelector('.cicwl-deactivate-submit');
        var cancelBtn = overlay.querySelector('.cicwl-deactivate-cancel');

        Array.prototype.forEach.call(radios, function (radio) {
            radio.addEventListener('change', function () {
                proPitch.hidden = radio.value !== 'missing_feature';
            });
        });

        function close() {
            if (overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }

        cancelBtn.addEventListener('click', close);
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                close();
            }
        });
        document.addEventListener('keydown', function onKey(e) {
            if (e.key === 'Escape') {
                close();
                document.removeEventListener('keydown', onKey);
            }
        });

        submitBtn.addEventListener('click', function () {
            var selected = overlay.querySelector('input[name="cicwl_deactivate_reason"]:checked');
            var reason = selected ? selected.value : 'no_reason_given';
            submitFeedback(reason);
            window.location.href = deactivateUrl;
        });
    }

    ready(function () {
        var link = findDeactivateLink();
        if (!link) {
            return;
        }
        link.addEventListener('click', function (e) {
            e.preventDefault();
            buildModal(link.href);
        });
    });
})();
