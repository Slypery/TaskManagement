var active_modal = [];
var active_modal_button = [];
import $ from 'jquery';

function trapFocus(modal_target) {
    var focusable_elements = modal_target.find('a[href], button, textarea, input[type="number"], input[type="text"], input[type="email"], input[type="password"], input[type="radio"], input[type="checkbox"], select, [tabindex]:not([tabindex="-1"])');
    var first_focusable_element = focusable_elements.first();
    var last_focusable_element = focusable_elements.last();

    $(document).on('keydown.focusTrap', function (event) {
        requestAnimationFrame(() => {
            var is_focus_contained = false;
            focusable_elements.each(function () {
                if ($(this).is($(document.activeElement))) {
                    is_focus_contained = true;
                    return;
                }
            });

            if (!is_focus_contained) {
                first_focusable_element.focus();
            }
        });

        if (!(event.key === 'Tab' || event.keyCode === 9)) {
            return;
        }

        if (event.shiftKey) {
            if ($(document.activeElement).is(first_focusable_element)) {
                event.preventDefault();
                last_focusable_element.focus();
            }
        } else {
            if ($(document.activeElement).is(last_focusable_element)) {
                event.preventDefault();
                first_focusable_element.focus();
            }
        }
    });
}

function show_modal(modal_target_string) {
    requestAnimationFrame(() => {
        modal_target.attr('data-modal', 'visible');
        modal_target.find('[data-modal-child]').attr('data-modal-child', 'visible');
    });
    $(document).off('keydown.focusTrap');
    const modal_target = $(modal_target_string);
    modal_target.attr('data-modal', '');
    trapFocus(modal_target);
    active_modal.push(modal_target);
}

function close_modal(modal_target) {
    $(document).off('keydown.focusTrap');
    active_modal.pop();
    if (active_modal[active_modal.length - 1]) {
        trapFocus(active_modal[active_modal.length - 1]);
    }
    modal_target.find('[data-modal-child]').attr('data-modal-child', '');
    requestAnimationFrame(() => {
        modal_target.attr('data-modal', '');
    });
    setTimeout(() => {
        modal_target.attr('data-modal', 'hidden');
    }, 200);
}

$(() => {
    let modal_container = $('[data-modal-container]');
    $('[data-modal]').each(function () {
        modal_container.append($(this).prop('outerHTML'));
        $(this).remove();
    });
    let $document = $(document);

    $document.on('click', '[data-modal-trigger]', function () {
        show_modal($(this).attr('data-modal-trigger'));
        active_modal_button.push(this);
    });

    $document.on('click', '[data-modal-close]', function () {
        close_modal($(this).closest('[data-modal]'));
    });

    $document.on('click', '[data-modal]', function (event) {
        if (event.target === this) {
            close_modal($(this));
        }
    });

    $document.on('keydown', function (e) {
        if (e.key == 'Escape') {
            close_modal($(active_modal.at(-1)));
        }
    });
});
