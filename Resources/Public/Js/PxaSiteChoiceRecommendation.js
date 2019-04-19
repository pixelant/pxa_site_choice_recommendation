PxaSiteChoiceRecommendation = function () {

    const COOKIE_NAME = 'pxa_site_choice_bar_hide';

    /**
     * @constructor
     */
    function PxaSiteChoiceRecommendation() {
        // Active choice url
        this.currentSelectedUrl = null;

        // Ajax loading bar url
        this.ajaxUrl = '?type=8790341';
        // Default settings
        this._defaultSettings = {
            querySelector: 'body',
            insertMethod: 'insertBefore',

            /** Bar elements Dom selectors **/
            selectBox: '[data-site-choice-select="1"]',
            selectBoxActiveClass: '_open',
            selectBoxSelectedItem: '[data-selected-item="1"]',
            selectBoxChoiceItem: '[data-choice-item="1"]',
            acceptButton: '[data-accept-choice="1"]',
            closeButton: '[data-close="1"]',
        };

        // Settings loaded with ajax
        this.customSettings = {};
    }

    let proto = PxaSiteChoiceRecommendation.prototype;

    /**
     * Load bar with ajax
     *
     * @param callback
     * @param url
     */
    proto.loadBar = function (callback, url) {
        let self = this;

        url = url || this.ajaxUrl;

        let xhr = this.__getXhr();

        xhr.addEventListener('load', function () {
            if (this.readyState === 4 && this.status === 200) {
                let response = JSON.parse(this.responseText);

                // Own callback provided
                if (typeof callback === 'function') {
                    callback(response);
                } else {
                    self._defaultProcessBarResponse(response);
                }
            }
        });

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send();
    };

    /**
     * Check if bar proposal was already shown
     *
     * @return {boolean}
     */
    proto.isBarEnabled = function () {
        if (typeof force_hide_site_choice_recommendation !== 'undefined'
            && force_hide_site_choice_recommendation === 1
        ) {
            return false;
        }

        let cookieValue = parseInt(this.getCookie(COOKIE_NAME));

        return cookieValue !== 1;
    };

    /**
     * Default bar processing
     *
     * @param response
     * @private
     */
    proto._defaultProcessBarResponse = function (response) {
        let self = this;

        if (response.visible) {
            this.customSettings = response.settings || {};

            let querySelector = this.getSettingValueOrDefault('querySelector'),
                insertMethod = this.getSettingValueOrDefault('insertMethod'),
                bar = this.__htmlToElement(response.html);

            let parentDom = document.querySelector(querySelector);

            if (insertMethod === 'insertBefore') {
                parentDom.insertBefore(bar, parentDom.firstChild);
            } else {
                parentDom[insertMethod](bar);
            }

            // Attach events to bar
            let selectBox = bar.querySelector(this.getSettingValueOrDefault('selectBox')),
                acceptButton = bar.querySelector(this.getSettingValueOrDefault('acceptButton')),
                closeButton = bar.querySelector(this.getSettingValueOrDefault('closeButton')),
                selectedItem = selectBox.querySelector(this.getSettingValueOrDefault('selectBoxSelectedItem')),
                choiceItems = selectBox.querySelectorAll(this.getSettingValueOrDefault('selectBoxChoiceItem'));

            // Set url from current selected item
            this.currentSelectedUrl = selectedItem.dataset.href;

            acceptButton.onclick = function () {
                self._acceptClick();
            };
            closeButton.onclick = function () {
                self._closeClick(bar);
            };
            selectBox.onclick = function (e) {
                self._selectBoxClick(selectBox, e);
            };

            this._choiceItemsClick(choiceItems, selectedItem);

            window.onclick = function (e) {
                if (false === selectBox.contains(e.target)) {
                    selectBox.classList.remove(self.getSettingValueOrDefault('selectBoxActiveClass'));
                }
            };
        }
    };

    /**
     * Set cookie
     *
     * @param cName
     * @param value
     * @param exdays
     */
    proto.setCookie = function (cName, value, exdays) {
        let exdate = new Date();

        exdate.setDate(exdate.getDate() + exdays);
        let cValue = encodeURIComponent(value) + ((exdays === null) ? '' : '; expires=' + exdate.toUTCString()) + '; path=/';
        document.cookie = cName + '=' + cValue;
    };

    /**
     * Get cookie
     *
     * @param cName
     * @return {string}|{boolean}
     */
    proto.getCookie = function (cName) {
        let i, x, y, ARRcookies = document.cookie.split(';');
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf('='));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf('=') + 1);
            x = x.replace(/^\s+|\s+$/g, '');
            if (x === cName) {
                return decodeURIComponent(y);
            }
        }

        return false;
    };

    /**
     * Get value from settigns or return default value
     *
     * @param setting
     * @return {*|string|Object}
     * @private
     */
    proto.getSettingValueOrDefault = function (setting) {
        return this.customSettings[setting] || this.getDefaultSettings(setting);
    };

    /**
     * Get default settings
     *
     * @param concreteSetting If specified - value of provided setting returned
     * @return {string|object}
     * @private
     */
    proto.getDefaultSettings = function (concreteSetting) {
        if (typeof concreteSetting === 'string') {
            return this._defaultSettings[concreteSetting] || null;
        }

        return this._defaultSettings;
    };

    /**
     * Set cookie that hides bar
     */
    proto.markBarAsHidden = function () {
        this.setCookie(COOKIE_NAME, 1);
    };

    /**
     * Action when user accept some language proposal
     *
     * @private
     */
    proto._acceptClick = function () {
        if (this.currentSelectedUrl) {
            window.location = this.currentSelectedUrl;
        } else {
            console.error('Choice url is not valid');
        }
    };

    /**
     * Hide bar
     *
     * @param bar
     * @private
     */
    proto._closeClick = function (bar) {
        bar.style.cssText = 'display:none;visibility:hidden;';
        this.markBarAsHidden();
    };

    /**
     * Handle click on select box
     *
     * @param selectBox
     * @param event
     * @private
     */
    proto._selectBoxClick = function (selectBox, event) {
        event.preventDefault();

        selectBox.classList.toggle(this.getSettingValueOrDefault('selectBoxActiveClass'));
    };

    /**
     * Track clicks on select items
     *
     * @param items
     * @param selectedItem
     * @private
     */
    proto._choiceItemsClick = function (items, selectedItem) {
        const self = this;

        for (let i = 0; i < items.length; i++) {
            let choice = items[i];

            choice.onclick = function (e) {
                e.preventDefault();
                selectedItem.innerHTML = choice.innerHTML;
                self.currentSelectedUrl = choice.href;
            }
        }
    };

    /**
     * Create element from bar html
     *
     * @param html
     * @return {boolean}
     * @private
     */
    proto.__htmlToElement = function (html) {
        let template = document.createElement('template');
        template.innerHTML = html.trim();

        return template.content.firstChild;
    };

    /**
     * Detect xhr
     *
     * @return {XMLHttpRequest|ActiveXObject}
     */
    proto.__getXhr = function () {
        if (typeof XMLHttpRequest !== 'undefined') {
            return new XMLHttpRequest();
        }
        let versions = [
            "MSXML2.XmlHttp.6.0",
            "MSXML2.XmlHttp.5.0",
            "MSXML2.XmlHttp.4.0",
            "MSXML2.XmlHttp.3.0",
            "MSXML2.XmlHttp.2.0",
            "Microsoft.XmlHttp"
        ];

        let xhr;
        for (let i = 0; i < versions.length; i++) {
            try {
                xhr = new ActiveXObject(versions[i]);
                break;
            } catch (e) {
            }
        }

        return xhr;
    };

    return PxaSiteChoiceRecommendation;
}();