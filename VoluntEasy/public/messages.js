/*!
 *  Lang.js for Laravel localization in JavaScript.
 *
 *  @version 1.1.0
 *  @license MIT
 *  @site    https://github.com/rmariuzzo/Laravel-JS-Localization
 *  @author  rmariuzzo
 */

'use strict';

(function(root, factory) {

    if (typeof define === 'function' && define.amd) {
        // AMD support.
        define([], factory);
    } else if (typeof exports === 'object') {
        // NodeJS support.
        module.exports = new(factory())();
    } else {
        // Browser global support.
        root.Lang = new(factory())();
    }

}(this, function() {

    // Default options //

    var defaults = {
        defaultLocale: 'en' /** The default locale if not set. */
    };

    // Constructor //

    var Lang = function(options) {
        options = options || {};
        this.defaultLocale = options.defaultLocale || defaults.defaultLocale;
    };

    // Methods //

    /**
     * Set messages source.
     *
     * @param messages {object} The messages source.
     *
     * @return void
     */
    Lang.prototype.setMessages = function(messages) {
        this.messages = messages;
    };

    /**
     * Returns a translation message.
     *
     * @param key {string} The key of the message.
     * @param replacements {object} The replacements to be done in the message.
     *
     * @return {string} The translation message, if not found the given key.
     */
    Lang.prototype.get = function(key, replacements) {
        if (!this.has(key)) {
            return key;
        }

        var message = this._getMessage(key, replacements);
        if (message === null) {
            return key;
        }

        if (replacements) {
            message = this._applyReplacements(message, replacements);
        }

        return message;
    };

    /**
     * Returns true if the key is defined on the messages source.
     *
     * @param key {string} The key of the message.
     *
     * @return {boolean} true if the given key is defined on the messages source, otherwise false.
     */
    Lang.prototype.has = function(key) {
        if (typeof key !== 'string' || !this.messages) {
            return false;
        }
        return this._getMessage(key) !== null;
    };

    /**
     * Gets the plural or singular form of the message specified based on an integer value.
     *
     * @param key {string} The key of the message.
     * @param count {integer} The number of elements.
     * @param replacements {object} The replacements to be done in the message.
     *
     * @return {string} The translation message according to an integer value.
     */
    Lang.prototype.choice = function(key, count, replacements) {
        // Set default values for parameters replace and locale
        replacements = typeof replacements !== 'undefined' ? replacements : {};
        
        // The count must be replaced if found in the message
        replacements['count'] = count;

        // Message to get the plural or singular
        var message = this.get(key, replacements);

        // Check if message is not null or undefined
        if (message === null || message === undefined) {
            return message;
        }

        // Separate the plural from the singular, if any
        var messageParts = message.split('|');

        // Get the explicit rules, If any
        var explicitRules = [];
        var regex = /{\d+}\s(.+)|\[\d+,\d+\]\s(.+)|\[\d+,Inf\]\s(.+)/;

        for (var i = 0; i < messageParts.length; i++) {
            messageParts[i] = messageParts[i].trim();

            if (regex.test(messageParts[i])) {
                var messageSpaceSplit = messageParts[i].split(/\s/);
                explicitRules.push(messageSpaceSplit.shift());
                messageParts[i] = messageSpaceSplit.join(' ');
            }
        }

        // Check if there's only one message
        if (messageParts.length === 1) {
            // Nothing to do here
            return message;
        }

        // Check the explicit rules
        for (var i = 0; i < explicitRules.length; i++) {
            if (this._testInterval(count, explicitRules[i])) {
                return messageParts[i];
            }
        }

        // Standard rules
        if (count > 1) {
            return messageParts[1];
        } else {
            return messageParts[0];
        }
    };

    /**
     * Set the current locale.
     *
     * @param locale {string} The locale to set.
     *
     * @return void
     */
    Lang.prototype.setLocale = function(locale) {
        this.locale = locale;
    };

    /**
     * Get the current locale.
     *
     * @return {string} The current locale.
     */
    Lang.prototype.getLocale = function() {
        return this.locale || this.defaultLocale;
    };

    /**
     * Parse a message key into components.
     *
     * @param key {string} The message key to parse.
     *
     * @return {object} A key object with source and entries properties.
     */
    Lang.prototype._parseKey = function(key) {
        if (typeof key !== 'string') {
            return null;
        }
        var segments = key.split('.');
        return {
            source: this.getLocale() + '.' + segments[0],
            entries: segments.slice(1)
        };
    };

    /**
     * Returns a translation message. Use `Lang.get()` method instead, this methods assumes the key exists.
     *
     * @param key {string} The key of the message.
     *
     * @return {string} The translation message for the given key.
     */
    Lang.prototype._getMessage = function(key) {

        key = this._parseKey(key);

        // Ensure message source exists.
        if (this.messages[key.source] === undefined) {
            return null;
        }

        // Get message text.
        var message = this.messages[key.source];
        while (key.entries.length && (message = message[key.entries.shift()]));

        if (typeof message !== 'string') {
            return null;
        }

        return message;
    };

    /**
     * Apply replacements to a string message containing placeholders.
     *
     * @param message {string} The text message.
     * @param replacements {object} The replacements to be done in the message.
     *
     * @return {string} The string message with replacements applied.
     */
    Lang.prototype._applyReplacements = function(message, replacements) {
        for (var replace in replacements) {
            message = message.split(':' + replace).join(replacements[replace]);
        }
        return message;
    };

    /**
     * Checks if the given `count` is within the interval defined by the {string} `interval`
     *
     * @param  count {int}  The amount of items.
     * @param  interval {string}    The interval to be compared with the count.
     * @return {boolean}    Returns true if count is within interval; false otherwise.
     */
    Lang.prototype._testInterval = function(count, interval) {
        /**
         * From the Symfony\Component\Translation\Interval Docs
         *
         * Tests if a given number belongs to a given math interval.
         * An interval can represent a finite set of numbers: {1,2,3,4}
         * An interval can represent numbers between two numbers: [1, +Inf] ]-1,2[
         * The left delimiter can be [ (inclusive) or ] (exclusive).
         * The right delimiter can be [ (exclusive) or ] (inclusive).
         * Beside numbers, you can use -Inf and +Inf for the infinite.
         */

        return false;
    };

    return Lang;

}));


(function(root) {
    Lang.setMessages({"el.pagination":{"previous":"&laquo; \u03a0\u03c1\u03bf\u03b7\u03b3\u03bf\u03cd\u03bc\u03b5\u03bd\u03bf","next":"\u0395\u03c0\u03cc\u03bc\u03b5\u03bd\u03bf &raquo;"},"el.passwords":{"password":"\u039f \u03ba\u03c9\u03b4\u03b9\u03ba\u03cc\u03c2 \u03b8\u03b1 \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03ad\u03c7\u03b5\u03b9 \u03bc\u03ae\u03ba\u03bf\u03c2 \u03c4\u03bf\u03c5\u03bb\u03ac\u03c7\u03b9\u03c3\u03c4\u03bf\u03bd 6 \u03c7\u03b1\u03c1\u03b1\u03ba\u03c4\u03ae\u03c1\u03b5\u03c2.","user":"\u0394\u03b5\u03bd \u03c5\u03c0\u03ac\u03c1\u03c7\u03b5\u03b9 \u03c7\u03c1\u03ae\u03c3\u03c4\u03b7\u03c2 \u03bc\u03b5 \u03b1\u03c5\u03c4\u03cc \u03c4\u03bf email.","token":"\u03a4\u03bf password reset token \u03b4\u03b5\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03bf.","sent":"\u03a3\u03b1\u03c2 \u03b1\u03c0\u03b5\u03c3\u03c4\u03ac\u03bb\u03b7 \u03bc\u03ad\u03c3\u03c9 email \u03bf \u03c3\u03cd\u03bd\u03b4\u03b5\u03c3\u03bc\u03bf\u03c2 \u03b5\u03c0\u03b1\u03bd\u03b1\u03c6\u03bf\u03c1\u03ac\u03c2 \u03ba\u03c9\u03b4\u03b9\u03ba\u03bf\u03cd \u03c0\u03c1\u03cc\u03c3\u03b2\u03b1\u03c3\u03b7\u03c2!","reset":"\u0395\u03b3\u03af\u03bd\u03b5 \u03b5\u03c0\u03b1\u03bd\u03b1\u03c6\u03bf\u03c1\u03ac \u03ba\u03c9\u03b4\u03b9\u03ba\u03bf\u03cd!"},"el.auth.login":{"title":"VoluntEasy","logIn":"\u03a3\u03cd\u03bd\u03b4\u03b5\u03c3\u03b7","remember":"\u039d\u03b1 \u03bc\u03b5 \u03b8\u03c5\u03bc\u03ac\u03c3\u03b1\u03b9 \u03c4\u03b7\u03bd \u03b5\u03c0\u03cc\u03bc\u03b5\u03bd\u03b7 \u03c6\u03bf\u03c1\u03ac","entrance":"\u0395\u03af\u03c3\u03bf\u03b4\u03bf\u03c2","forgotPass":"\u039e\u03b5\u03c7\u03ac\u03c3\u03b1\u03c4\u03b5 \u03c4\u03bf\u03bd \u03ba\u03c9\u03b4\u03b9\u03ba\u03cc \u03c3\u03b1\u03c2;","register":"\u0394\u03b7\u03bc\u03b9\u03bf\u03c5\u03c1\u03b3\u03af\u03b1 \u039b\u03bf\u03b3\u03b1\u03c1\u03b9\u03b1\u03c3\u03bc\u03bf\u03cd"},"el.templates.pageTitle":{"home":"\u0391\u03c1\u03c7\u03b9\u03ba\u03ae","dashboard":"Dashboard"},"el.templates.topBar":{"title":"VoluntEasy","youHave":"\u0388\u03c7\u03b5\u03c4\u03b5","notifications":"\u03b5\u03b9\u03b4\u03bf\u03c0\u03bf\u03b9\u03ae\u03c3\u03b5\u03b9\u03c2","allNotifications":"\u038c\u03bb\u03b5\u03c2 \u03bf\u03b9 \u03b5\u03b9\u03b4\u03bf\u03c0\u03bf\u03b9\u03ae\u03c3\u03b5\u03b9\u03c2","logOut":"\u0391\u03c0\u03bf\u03c3\u03cd\u03bd\u03b4\u03b5\u03c3\u03b7","lockScreen":"\u039a\u03bb\u03b5\u03af\u03b4\u03c9\u03bc\u03b1 \u039f\u03b8\u03cc\u03bd\u03b7\u03c2","profile":"\u03a0\u03c1\u03bf\u03c6\u03af\u03bb","tasks":"\u039f\u03b9 \u03b5\u03ba\u03ba\u03c1\u03b5\u03bc\u03cc\u03c4\u03b7\u03c4\u03ad\u03c2 \u03bc\u03bf\u03c5","faq":"\u0392\u03bf\u03ae\u03b8\u03b5\u03b9\u03b1"},"el.templates.menu":{"dashboard":"\u0391\u03c1\u03c7\u03b9\u03ba\u03ae","units":"\u039f\u03c1\u03b3\u03b1\u03bd\u03c9\u03c4\u03b9\u03ba\u03ad\u03c2 \u039c\u03bf\u03bd\u03ac\u03b4\u03b5\u03c2","showUnits":"\u03a0\u03c1\u03bf\u03b2\u03bf\u03bb\u03ae \u039f\u03c1\u03b3\u03b1\u03bd\u03c9\u03c4\u03b9\u03ba\u03ce\u03bd \u039c\u03bf\u03bd\u03ac\u03b4\u03c9\u03bd","createUnit":"\u0394\u03b7\u03bc\u03b9\u03bf\u03c5\u03c1\u03b3\u03af\u03b1 \u039f\u03c1\u03b3\u03b1\u03bd\u03c9\u03c4\u03b9\u03ba\u03ae\u03c2 \u039c\u03bf\u03bd\u03ac\u03b4\u03b1\u03c2","actions":"\u0394\u03c1\u03ac\u03c3\u03b5\u03b9\u03c2 & \u03a0\u03c1\u03bf\u03b3\u03c1\u03ac\u03bc\u03bc\u03b1\u03c4\u03b1","showActions":"\u03a0\u03c1\u03bf\u03b2\u03bf\u03bb\u03ae \u0394\u03c1\u03ac\u03c3\u03b5\u03c9\u03bd","createAction":"\u0394\u03b7\u03bc\u03b9\u03bf\u03c5\u03c1\u03b3\u03af\u03b1 \u0394\u03c1\u03ac\u03c3\u03b7\u03c2","collaborations":"\u03a3\u03c5\u03bd\u03b5\u03c1\u03b3\u03b1\u03b6\u03cc\u03bc\u03b5\u03bd\u03bf\u03b9 \u03a6\u03bf\u03c1\u03b5\u03af\u03c2","showCollaborations":"\u03a0\u03c1\u03bf\u03b2\u03bf\u03bb\u03ae \u03a3\u03c5\u03bd\u03b5\u03c1\u03b3\u03b1\u03b6\u03cc\u03bc\u03b5\u03bd\u03c9\u03bd \u03a6\u03bf\u03c1\u03ad\u03c9\u03bd","createCollaboration":"\u0394\u03b7\u03bc\u03b9\u03bf\u03c5\u03c1\u03b3\u03af\u03b1 \u03a3\u03c5\u03bd\u03b5\u03c1\u03b3\u03b1\u03b6\u03cc\u03bc\u03b5\u03bd\u03bf\u03c5 \u03a6\u03bf\u03c1\u03ad\u03b1","volunteers":"\u0395\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ad\u03c2","showVolunteers":"\u03a0\u03c1\u03bf\u03b2\u03bf\u03bb\u03ae \u0395\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ce\u03bd","createVolunteer":"\u0394\u03b7\u03bc\u03b9\u03bf\u03c5\u03c1\u03b3\u03af\u03b1 \u0395\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ae","volunteerStatistcs":"\u03a3\u03c4\u03b1\u03c4\u03b9\u03c3\u03c4\u03b9\u03ba\u03ad\u03c2 \u0391\u03bd\u03b1\u03bb\u03cd\u03c3\u03b5\u03b9\u03c2","users":"\u03a7\u03c1\u03ae\u03c3\u03c4\u03b5\u03c2","createUser":"\u0394\u03b7\u03bc\u03b9\u03bf\u03c5\u03c1\u03b3\u03af\u03b1 \u03a7\u03c1\u03ae\u03c3\u03c4\u03b7","showUsers":"\u03a0\u03c1\u03bf\u03b2\u03bf\u03bb\u03ae \u03a7\u03c1\u03b7\u03c3\u03c4\u03ce\u03bd","tree":"\u0394\u03ad\u03bd\u03c4\u03c1\u03bf","tasks":"\u039f\u03b9 \u03b5\u03ba\u03ba\u03c1\u03b5\u03bc\u03cc\u03c4\u03b7\u03c4\u03ad\u03c2 \u03bc\u03bf\u03c5","reports":"Reports"},"el.js-components":{"lengthMenu":"_MENU_ \u03b3\u03c1\u03b1\u03bc\u03bc\u03ad\u03c2 \u03b1\u03bd\u03ac \u03c3\u03b5\u03bb\u03af\u03b4\u03b1","info":"\u03a3\u03b5\u03bb\u03af\u03b4\u03b1 _PAGE_ \u03b1\u03c0\u03cc _PAGES_","first":"\u03a0\u03c1\u03ce\u03c4\u03b7","last":"\u03a4\u03b5\u03bb\u03b5\u03c5\u03c4\u03b1\u03af\u03b1","zeroVolunteers":"\u0394\u03b5\u03bd \u03c5\u03c0\u03ac\u03c1\u03c7\u03bf\u03c5\u03bd \u03b5\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ad\u03c2"},"el.default":{"title":"VoluntEasy","volRating":"\u0391\u03be\u03b9\u03bf\u03bb\u03cc\u03b3\u03b7\u03c3\u03b7","admin":"\u0394\u03b9\u03b1\u03c7\u03b5\u03b9\u03c1\u03b9\u03c3\u03c4\u03ae\u03c2","unit_manager":"\u03a5\u03c0\u03b5\u03cd\u03b8\u03c5\u03bd\u03bf\u03c2 \u039c\u03bf\u03bd\u03ac\u03b4\u03c9\u03bd","action_manager":"\u03a5\u03c0\u03b5\u03cd\u03b8\u03c5\u03bd\u03bf\u03c2 \u0394\u03c1\u03ac\u03c3\u03b5\u03c9\u03bd","admin-descr":"\u039f \u0394\u03b9\u03b1\u03c7\u03b5\u03b9\u03c1\u03b9\u03c3\u03c4\u03ae\u03c2 \u03b5\u03af\u03bd\u03b1\u03b9 \u03c5\u03c0\u03b5\u03cd\u03b8\u03c5\u03bd\u03bf\u03c2 \u03b3\u03b9\u03b1 \u03cc\u03bb\u03b5\u03c2 \u03c4\u03b9\u03c2 \u03bc\u03bf\u03bd\u03ac\u03b4\u03b5\u03c2 \u03ba\u03b1\u03b9 \u03b4\u03c1\u03ac\u03c3\u03b5\u03b9\u03c2 \u03c4\u03bf\u03c5 \u03bf\u03c1\u03b3\u03b1\u03bd\u03b9\u03c3\u03bc\u03bf\u03cd.","unit_manager-descr":"\u039f \u03a5\u03c0\u03b5\u03cd\u03b8\u03c5\u03bd\u03bf\u03c2 \u039c\u03bf\u03bd\u03ac\u03b4\u03c9\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03c5\u03c0\u03b5\u03cd\u03b8\u03c5\u03bd\u03bf\u03c2 \u03b3\u03b9\u03b1 \u03c4\u03b9\u03c2 \u03bf\u03c1\u03b3\u03b1\u03bd\u03c9\u03c4\u03b9\u03ba\u03ad\u03c2 \u03bc\u03bf\u03bd\u03b1\u03b4\u03b5\u03c2 \u03c3\u03c4\u03b9\u03c2 \u03bf\u03c0\u03bf\u03af\u03b5\u03c2 \u03ad\u03c7\u03b5\u03b9 \u03b1\u03bd\u03b1\u03c4\u03b5\u03b8\u03b5\u03af.","action_manager-descr":"\u039f \u03a5\u03c0\u03b5\u03cd\u03b8\u03c5\u03bd\u03bf\u03c2 \u0394\u03c1\u03ac\u03c3\u03b5\u03c9\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03c5\u03c0\u03b5\u03cd\u03b8\u03c5\u03bd\u03bf\u03c2 \u03b3\u03b9\u03b1 \u03c4\u03b9\u03c2 \u03b4\u03c1\u03ac\u03c3\u03b5\u03b9\u03c2 \u03c3\u03c4\u03b9\u03c2 \u03bf\u03c0\u03bf\u03af\u03b5\u03c2 \u03ad\u03c7\u03b5\u03b9 \u03b1\u03bd\u03b1\u03c4\u03b5\u03b8\u03b5\u03af.","admin-at":"\u0394\u03b9\u03b1\u03c7\u03b5\u03b9\u03c1\u03b9\u03c3\u03c4\u03ae\u03c2","unit_manager-at":"\u03a5\u03c0\u03b5\u03cd\u03b8\u03c5\u03bd\u03bf\u03c2 \u039c\u03bf\u03bd\u03ac\u03b4\u03c9\u03bd \u03c3\u03c4\u03b9\u03c2 \u03bc\u03bf\u03bd\u03ac\u03b4\u03b5\u03c2:","action_manager-at":"\u03a5\u03c0\u03b5\u03cd\u03b8\u03c5\u03bd\u03bf\u03c2 \u0394\u03c1\u03ac\u03c3\u03b5\u03c9\u03bd \u03c3\u03c4\u03b9\u03c2 \u03b4\u03c1\u03ac\u03c3\u03b5\u03b9\u03c2:","complete":"\u039f\u03bb\u03bf\u03ba\u03bb\u03b7\u03c1\u03c9\u03bc\u03ad\u03bd\u03b7","incomplete":"\u039c\u03b7 \u039f\u03bb\u03bf\u03ba\u03bb\u03b7\u03c1\u03c9\u03bc\u03ad\u03bd\u03b7","inprogress":"\u03a3\u03b5 \u03b5\u03be\u03ad\u03bb\u03b9\u03be\u03b7","pending":"\u0395\u03ba\u03ba\u03c1\u03b5\u03bc\u03b5\u03af","priority-urgent":"\u0395\u03c0\u03b5\u03af\u03b3\u03bf\u03bd","priority-high":"\u03a5\u03c8\u03b7\u03bb\u03ae","priority-medium":"\u039c\u03b5\u03c3\u03b1\u03af\u03b1","priority-low":"\u03a7\u03b1\u03bc\u03b7\u03bb\u03ae"},"el.entities.actions":{"action":"\u0394\u03c1\u03ac\u03c3\u03b7","actions":"\u0394\u03c1\u03ac\u03c3\u03b5\u03b9\u03c2","new.capitals":"\u0395\u039d\u0395\u03a1\u0393\u0395\u03a3 \u0394\u03a1\u0391\u03a3\u0395\u0399\u03a3","calendar":"\u0397\u03bc\u03b5\u03c1\u03bf\u03bb\u03cc\u03b3\u03b9\u03bf \u0394\u03c1\u03ac\u03c3\u03b5\u03c9\u03bd"},"el.entities.units":{"unit":"\u039c\u03bf\u03bd\u03ac\u03b4\u03b1","units":"\u039c\u03bf\u03bd\u03ac\u03b4\u03b5\u03c2"},"el.entities.volunteers":{"volunteer":"","new":"\u039d\u03ad\u03bf\u03b9 \u0395\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ad\u03c2","pending":"\u03a5\u03c0\u03cc \u0388\u03bd\u03c4\u03b1\u03be\u03b7 \u0395\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ad\u03c2","available":"\u0394\u03b9\u03b1\u03b8\u03ad\u03c3\u03b9\u03bc\u03bf\u03b9 \u0395\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ad\u03c2","active":"\u0395\u03bd\u03b5\u03c1\u03b3\u03bf\u03af \u0395\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ad\u03c2","new.capitals":"\u039d\u0395\u039f\u0399 \u0395\u0398\u0395\u039b\u039f\u039d\u03a4\u0395\u03a3","pending.capitals":"\u03a5\u03a0\u039f \u0388\u039d\u03a4\u0391\u039e\u0397 \u0395\u0398\u0395\u039b\u039f\u039d\u03a4\u0395\u03a3","available.capitals":"\u0394\u0399\u0391\u0398\u0395\u03a3\u0399\u039c\u039f\u0399 \u0395\u0398\u0395\u039b\u039f\u039d\u03a4\u0395\u03a3","active.capitals":"\u0395\u039d\u0395\u03a1\u0393\u039f\u0399 \u0395\u0398\u0395\u039b\u039f\u039d\u03a4\u0395\u03a3","reports.status-pie":"\u0394\u03b9\u03ac\u03b3\u03c1\u03b1\u03bc\u03bc\u03b1 \u0395\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ce\u03bd","birthdayToday":"\u0388\u03c7\u03bf\u03c5\u03bd \u03b3\u03b5\u03bd\u03ad\u03b8\u03bb\u03b9\u03b1 \u03c3\u03ae\u03bc\u03b5\u03c1\u03b1","noBirthday":"\u039a\u03b1\u03bd\u03ad\u03bd\u03b1\u03c2 \u03b5\u03b8\u03b5\u03bb\u03bf\u03bd\u03c4\u03ae\u03c2 \u03b4\u03b5\u03bd \u03ad\u03c7\u03b5\u03b9 \u03b3\u03b5\u03bd\u03ad\u03b8\u03bb\u03b9\u03b1 \u03c3\u03ae\u03bc\u03b5\u03c1\u03b1","id":"ID","name":"\u038c\u03bd\u03bf\u03bc\u03b1","activities":"\u0395\u03bd\u03ad\u03c1\u03b3\u03b5\u03b9\u03b5\u03c2","pendingStuff":"\u0395\u03ba\u03ba\u03c1\u03b5\u03bc\u03cc\u03c4\u03b7\u03c4\u03b5\u03c2"},"el.home":{"home":"\u0391\u03c1\u03c7\u03b9\u03ba\u03ae","loggedIn":"\u0395\u03af\u03c3\u03c4\u03b5 \u03c3\u03c5\u03bd\u03b4\u03b5\u03b4\u03b5\u03bc\u03ad\u03bd\u03bf\u03c2!"},"el.validation":{"accepted":"\u039f\u03b9 :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03b9\u03bd\u03b1\u03b9 \u03b1\u03c0\u03bf\u03b4\u03b5\u03ba\u03c4\u03bf\u03af.","active_url":"\u03a4\u03bf :attribute \u03b4\u03b5\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03bf URL.","after":"\u0397 :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03b7\u03bc\u03b5\u03c1\u03bf\u03bc\u03b7\u03bd\u03af\u03b1 \u03bc\u03b5\u03c4\u03ac \u03b1\u03c0\u03cc \u03c4\u03b7\u03bd :date.","alpha":"\u03a4\u03bf :attribute \u03bc\u03c0\u03bf\u03c1\u03b5\u03af \u03bd\u03b1 \u03c0\u03b5\u03c1\u03b9\u03ad\u03c7\u03b5\u03b9 \u03bc\u03cc\u03bd\u03bf \u03b3\u03c1\u03ac\u03bc\u03bc\u03b1\u03c4\u03b1.","alpha_dash":"\u03a4\u03bf :attribute \u03bc\u03c0\u03bf\u03c1\u03b5\u03af \u03bd\u03b1 \u03c0\u03b5\u03c1\u03b9\u03ad\u03c7\u03b5\u03b9 \u03bc\u03cc\u03bd\u03bf \u03b1\u03bb\u03c6\u03b1\u03c1\u03b9\u03b8\u03bc\u03b7\u03c4\u03b9\u03ba\u03ac \u03ba\u03b1\u03b9 \u03c0\u03b1\u03cd\u03bb\u03b5\u03c2.","alpha_num":"\u03a4\u03bf :attribute \u03bc\u03c0\u03bf\u03c1\u03b5\u03af \u03bd\u03b1 \u03c0\u03b5\u03c1\u03b9\u03ad\u03c7\u03b5\u03b9 \u03bc\u03cc\u03bd\u03bf \u03b1\u03bb\u03c6\u03b1\u03c1\u03b9\u03b8\u03bc\u03b7\u03c4\u03b9\u03ba\u03ac.","array":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03c0\u03af\u03bd\u03b1\u03ba\u03b1\u03c2.","before":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03b7\u03bc\u03b5\u03c1\u03bf\u03bc\u03b7\u03bd\u03af\u03b1 \u03c0\u03c1\u03af\u03bd \u03c4\u03b7\u03bd :date.","between":{"numeric":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03bc\u03b5\u03c4\u03b1\u03be\u03cd :min \u03ba\u03b1\u03b9 :max.","file":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03bc\u03b5\u03c4\u03b1\u03be\u03cd :min \u03ba\u03b1\u03b9 :max kilobytes.","string":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03bc\u03b5\u03c4\u03b1\u03be\u03cd :min \u03ba\u03b1\u03b9 :max \u03c7\u03b1\u03c1\u03b1\u03ba\u03c4\u03ae\u03c1\u03b5\u03c2.","array":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03ad\u03c7\u03b5\u03b9 :min \u03ad\u03c9\u03c2 :max \u03b1\u03bd\u03c4\u03b9\u03ba\u03b5\u03af\u03bc\u03b5\u03bd\u03b1."},"boolean":"\u03a4\u03bf \u03c0\u03b5\u03b4\u03af\u03bf :attribute \u03bc\u03c0\u03bf\u03c1\u03b5\u03af \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 true \u03ae false.","confirmed":"\u0397 \u03b5\u03c0\u03b9\u03b2\u03b5\u03b2\u03b1\u03af\u03c9\u03c3\u03b7 \u03c4\u03bf\u03c5 :attribute \u03b4\u03b5\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03c3\u03c9\u03c3\u03c4\u03ae.","date":"\u0397 :attribute \u03b4\u03b5\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03b7 \u03b7\u03bc\u03b5\u03c1\u03bf\u03bc\u03b7\u03bd\u03af\u03b1.","date_format":"\u03a4\u03bf :attribute \u03b4\u03b5\u03bd \u03b1\u03ba\u03bf\u03bb\u03bf\u03c5\u03b8\u03b5\u03af \u03c4\u03bf format :format.","different":"\u03a4\u03bf :attribute \u03ba\u03b1\u03b9 :other \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03b4\u03b9\u03b1\u03c6\u03bf\u03c1\u03b5\u03c4\u03b9\u03ba\u03ac.","digits":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 :digits \u03c8\u03b7\u03c6\u03af\u03b1.","digits_between":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03bc\u03b5\u03c4\u03b1\u03be\u03cd :min \u03ba\u03b1\u03b9 :max \u03c8\u03b7\u03c6\u03af\u03c9\u03bd.","email":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03b7 \u03b4\u03b9\u03b5\u03cd\u03b8\u03c5\u03bd\u03c3\u03b7 email.","filled":"\u03a0\u03b1\u03c1\u03b1\u03ba\u03b1\u03bb\u03ce \u03c3\u03c5\u03bc\u03c0\u03bb\u03b7\u03c1\u03ce\u03c3\u03c4\u03b5 \u03c4\u03bf \u03c0\u03b5\u03b4\u03af\u03bf :attribute.","exists":"\u03a4\u03bf \u03b5\u03c0\u03b9\u03bb\u03b5\u03b3\u03bc\u03ad\u03bd\u03bf :attribute \u03b4\u03b5\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03bf.","image":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03b5\u03b9\u03ba\u03cc\u03bd\u03b1.","in":"\u03a4\u03bf \u03b5\u03c0\u03b9\u03bb\u03b5\u03b3\u03bc\u03ad\u03bd\u03bf :attribute \u03b4\u03b5\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03bf.","integer":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03b1\u03ba\u03ad\u03c1\u03b1\u03b9\u03bf\u03c2.","ip":"\u0397 :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03b7 \u03b4\u03b9\u03b5\u03cd\u03b8\u03c5\u03bd\u03c3\u03b7 IP.","max":{"numeric":"\u03a4\u03bf :attribute \u03b4\u03b5\u03bd \u03bc\u03c0\u03bf\u03c1\u03b5\u03af \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03bc\u03b5\u03b3\u03b1\u03bb\u03cd\u03c4\u03b5\u03c1\u03bf \u03c4\u03bf\u03c5 :max.","file":"\u03a4\u03bf :attribute \u03b4\u03b5\u03bd \u03bc\u03c0\u03bf\u03c1\u03b5\u03af \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03bc\u03b5\u03b3\u03b1\u03bb\u03cd\u03c4\u03b5\u03c1\u03bf \u03b1\u03c0\u03cc :max kilobytes.","string":"\u03a4\u03bf :attribute \u03b4\u03b5\u03bd \u03bc\u03c0\u03bf\u03c1\u03b5\u03af \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03bc\u03b5\u03b3\u03b1\u03bb\u03cd\u03c4\u03b5\u03c1\u03bf :max \u03c7\u03b1\u03c1\u03b1\u03ba\u03c4\u03ae\u03c1\u03b5\u03c2.","array":"\u03a4\u03bf :attribute \u03b4\u03b5\u03bd \u03bc\u03c0\u03bf\u03c1\u03b5\u03af \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03c0\u03b5\u03c1\u03b9\u03c3\u03c3\u03cc\u03c4\u03b5\u03c1\u03b1 \u03b1\u03c0\u03cc :max \u03b1\u03bd\u03c4\u03b9\u03ba\u03b5\u03af\u03bc\u03b5\u03bd\u03b1."},"mimes":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03b1\u03c1\u03c7\u03b5\u03af\u03bf \u03c4\u03cd\u03c0\u03bf\u03c5: :values.","min":{"numeric":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03c4\u03bf\u03c5\u03bb\u03ac\u03c7\u03b9\u03c3\u03c4\u03bf\u03bd :min.","file":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03c4\u03bf\u03c5\u03bb\u03ac\u03c7\u03b9\u03c3\u03c4\u03bf\u03bd :min kilobytes.","string":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03c4\u03bf\u03c5\u03bb\u03ac\u03c7\u03b9\u03c3\u03c4\u03bf\u03bd :min \u03c7\u03b1\u03c1\u03b1\u03ba\u03c4\u03ae\u03c1\u03b5\u03c2.","array":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03ad\u03c7\u03b5\u03b9 \u03c4\u03bf\u03c5\u03bb\u03ac\u03c7\u03b9\u03c3\u03c4\u03bf\u03bd :min \u03b1\u03bd\u03c4\u03b9\u03ba\u03b5\u03af\u03bc\u03b5\u03bd\u03b1."},"not_in":"\u03a4\u03bf \u03b5\u03c0\u03b9\u03bb\u03b5\u03b3\u03bc\u03ad\u03bd\u03bf :attribute \u03b4\u03b5\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03bf.","numeric":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03b1\u03c1\u03b9\u03b8\u03bc\u03cc\u03c2.","regex":"\u03a4\u03bf format \u03c4\u03bf\u03c5 :attribute \u03b4\u03b5\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03bf.","required":"\u03a0\u03b1\u03c1\u03b1\u03ba\u03b1\u03bb\u03ce \u03c3\u03c5\u03bc\u03c0\u03bb\u03b7\u03c1\u03ce\u03c3\u03c4\u03b5 \u03c4\u03bf \u03c0\u03b5\u03b4\u03af\u03bf.","required_if":"\u03a4\u03bf \u03c0\u03b5\u03b4\u03af\u03bf :attribute \u03b5\u03af\u03bd\u03b1\u03b9 \u03b1\u03c0\u03b1\u03b9\u03c4\u03bf\u03cd\u03bc\u03b5\u03bd\u03bf \u03cc\u03c4\u03b1\u03bd :other is :value.","required_with":"\u03a4\u03bf \u03c0\u03b5\u03b4\u03af\u03bf :attribute \u03b5\u03af\u03bd\u03b1\u03b9 \u03b1\u03c0\u03b1\u03b9\u03c4\u03bf\u03cd\u03bc\u03b5\u03bd\u03bf \u03cc\u03c4\u03b1\u03bd :values is present.","required_with_all":"\u03a4\u03bf \u03c0\u03b5\u03b4\u03af\u03bf :attribute \u03b5\u03af\u03bd\u03b1\u03b9 \u03b1\u03c0\u03b1\u03b9\u03c4\u03bf\u03cd\u03bc\u03b5\u03bd\u03bf \u03cc\u03c4\u03b1\u03bd :values is present.","required_without":"\u03a4\u03bf \u03c0\u03b5\u03b4\u03af\u03bf :attribute \u03b5\u03af\u03bd\u03b1\u03b9 \u03b1\u03c0\u03b1\u03b9\u03c4\u03bf\u03cd\u03bc\u03b5\u03bd\u03bf \u03cc\u03c4\u03b1\u03bd :values is not present.","required_without_all":"\u03a4\u03bf \u03c0\u03b5\u03b4\u03af\u03bf :attribute \u03b5\u03af\u03bd\u03b1\u03b9 \u03b1\u03c0\u03b1\u03b9\u03c4\u03bf\u03cd\u03bc\u03b5\u03bd\u03bf \u03cc\u03c4\u03b1\u03bd none of :values are present.","same":"\u03a4\u03bf \u03c0\u03b5\u03b4\u03af\u03bf :attribute \u03ba\u03b1\u03b9 :other \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03cc\u03bc\u03bf\u03b9\u03b1.","size":{"numeric":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 :size.","file":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 :size kilobytes.","string":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 :size \u03c7\u03b1\u03c1\u03b1\u03ba\u03c4\u03ae\u03c1\u03b5\u03c2.","array":"\u03a4\u03bf :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03c0\u03b5\u03c1\u03b9\u03ad\u03c7\u03b5\u03b9 \u03c4\u03bf\u03c5\u03bb\u03ac\u03c7\u03b9\u03c3\u03c4\u03bf\u03bd :size items."},"unique":"\u03a4\u03bf :attribute \u03c7\u03c1\u03b7\u03c3\u03b9\u03bc\u03bf\u03c0\u03bf\u03b5\u03af\u03c4\u03b1\u03b9 \u03ae\u03b4\u03b7.","url":"\u03a4\u03bf format \u03c4\u03bf\u03c5 :attribute \u03b4\u03b5\u03bd \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03bf.","timezone":"\u0397 :attribute \u03c0\u03c1\u03ad\u03c0\u03b5\u03b9 \u03bd\u03b1 \u03b5\u03af\u03bd\u03b1\u03b9 \u03ad\u03b3\u03ba\u03c5\u03c1\u03b7 \u03b6\u03ce\u03bd\u03b7.","custom":{"attribute-name":{"rule-name":"custom-message"}},"attributes":[]},"en.pagination":{"previous":"&laquo; Previous","next":"Next &raquo;"},"en.passwords":{"password":"Passwords must be at least six characters and match the confirmation.","user":"We can't find a user with that e-mail address.","token":"This password reset token is invalid.","sent":"We have e-mailed your password reset link!","reset":"Your password has been reset!"},"en.auth.login":{"title":"Title","logIn":"Login","remember":"Remember Me","entrance":"Entrance","forgotPass":"forgot your Password?","register":"Create Account"},"en.templates.pageTitle":{"home":"Home","dashboard":"Dashboard"},"en.templates.topBar":{"title":"Title","youHave":"You have","notifications":"notifications","allNotifications":"All notifications","logOut":"Log out","lockScreen":"Lock screen","profile":"Profile"},"en.templates.menu":{"units":"Management Entities","showUnits":"Show Management Entities","createUnit":"Create Management Entity","actions":"Actions","showActions":"Show Actions","createAction":"Create Action","volunteers":"Volunteers","showVolunteers":"Show Volunteers","createVolunteer":"Create Volunteer","volunteerStatistcs":"Statistics","users":"Users","createUser":"Create User","showUsers":"Show Users","tree":"Tree"},"en.default":{"title":"Title"},"en.home":{"home":"Home","loggedIn":"You are logged in!"},"en.validation":{"accepted":"The :attribute must be accepted.","active_url":"The :attribute is not a valid URL.","after":"The :attribute must be a date after :date.","alpha":"The :attribute may only contain letters.","alpha_dash":"The :attribute may only contain letters, numbers, and dashes.","alpha_num":"The :attribute may only contain letters and numbers.","array":"The :attribute must be an array.","before":"The :attribute must be a date before :date.","between":{"numeric":"The :attribute must be between :min and :max.","file":"The :attribute must be between :min and :max kilobytes.","string":"The :attribute must be between :min and :max characters.","array":"The :attribute must have between :min and :max items."},"boolean":"The :attribute field must be true or false.","confirmed":"The :attribute confirmation does not match.","date":"The :attribute is not a valid date.","date_format":"The :attribute does not match the format :format.","different":"The :attribute and :other must be different.","digits":"The :attribute must be :digits digits.","digits_between":"The :attribute must be between :min and :max digits.","email":"The :attribute must be a valid email address.","filled":"The :attribute field is required.","exists":"The selected :attribute is invalid.","image":"The :attribute must be an image.","in":"The selected :attribute is invalid.","integer":"The :attribute must be an integer.","ip":"The :attribute must be a valid IP address.","max":{"numeric":"The :attribute may not be greater than :max.","file":"The :attribute may not be greater than :max kilobytes.","string":"The :attribute may not be greater than :max characters.","array":"The :attribute may not have more than :max items."},"mimes":"The :attribute must be a file of type: :values.","min":{"numeric":"The :attribute must be at least :min.","file":"The :attribute must be at least :min kilobytes.","string":"The :attribute must be at least :min characters.","array":"The :attribute must have at least :min items."},"not_in":"The selected :attribute is invalid.","numeric":"The :attribute must be a number.","regex":"The :attribute format is invalid.","required":"The :attribute field is required.","required_if":"The :attribute field is required when :other is :value.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values is present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute and :other must match.","size":{"numeric":"The :attribute must be :size.","file":"The :attribute must be :size kilobytes.","string":"The :attribute must be :size characters.","array":"The :attribute must contain :size items."},"unique":"The :attribute has already been taken.","url":"The :attribute format is invalid.","timezone":"The :attribute must be a valid zone.","custom":{"attribute-name":{"rule-name":"custom-message"}},"attributes":[]}});
})(window);
