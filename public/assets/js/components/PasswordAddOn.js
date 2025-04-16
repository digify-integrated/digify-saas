/**
 * @function passwordAddOn
 * @description
 * Enhances password input fields with toggle visibility functionality.
 * Attaches click event listeners to elements with the `.password-addon` class.
 * When clicked, it toggles the input type between 'password' and 'text' to
 * show or hide the password, and switches the icon class accordingly.
 * 
 * The `.password-addon` element is also set to `tabindex = -1` to prevent
 * it from being focusable via keyboard navigation, improving accessibility.
 * 
 * Usage:
 * - Ensure that each `.password-addon` is placed adjacent to a password input.
 * - The toggle icon should be an <i> element inside `.password-addon`.
 */
export default function passwordAddOn() {
    const $addons = $('.password-addon');

    // Proceed only if password-addon elements exist
    if (!$addons.length) return;

    $addons.each(function () {
        const $addon = $(this);

        // Prevent keyboard focus for accessibility reasons
        $addon.attr('tabindex', -1);

        $addon.on('click', function () {
            const $input = $addon.siblings('input[type="password"], input[type="text"]');
            const $icon = $addon.find('i');

            if ($input.length) {
                const isPassword = $input.attr('type') === 'password';
                $input.attr('type', isPassword ? 'text' : 'password');

                // Toggle icon class to reflect current state
                $icon.toggleClass('ki-eye ki-eye-slash');
            }
        });
    });
}
