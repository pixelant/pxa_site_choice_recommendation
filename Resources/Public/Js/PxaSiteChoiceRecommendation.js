PxaSiteChoiceRecommendation = function () {

    const COOKIE_NAME = 'pxa_site_choice_bar_hide';

    /**
     * @constructor
     */
    function PxaSiteChoiceRecommendation() {
        // Ajax loading bar url
        this.ajaxUrl = '/?type=8790341';
        // Default settings
        this._defaultSettings = {
            querySelector: 'body',
            insertMethod: 'insertBefore',

            /** Bar elements Dom selectors **/
            selectBox: 'select',
            acceptButton: '[data-accept-choice="1"]',
            closeButton: '[data-close="1"]',
        }
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
            let settings = response.settings || this.getDefaultSettings();

            let querySelector = this.getSettingValueOrDefault(settings, 'querySelector'),
                insertMethod = this.getSettingValueOrDefault(settings, 'insertMethod'),
                bar = this.__htmlToElement(response.html);

            let parentDom = document.querySelector(querySelector);

            if (insertMethod === 'insertBefore') {
                parentDom.insertBefore(bar, parentDom.firstChild);
            } else {
                parentDom[insertMethod](bar);
            }

            // Attach events to bar
            let selectBox = bar.querySelector(this.getSettingValueOrDefault(settings, 'selectBox')),
                acceptButton = bar.querySelector(this.getSettingValueOrDefault(settings, 'acceptButton')),
                closeButton = bar.querySelector(this.getSettingValueOrDefault(settings, 'closeButton'));

            acceptButton.onclick = function () {
                self._acceptClick(selectBox);
            };
            closeButton.onclick = function () {
                self._closeClick(bar);
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
     * @param settings
     * @param setting
     * @return {*|string|Object}
     * @private
     */
    proto.getSettingValueOrDefault = function (settings, setting) {
        return settings[setting] || this.getDefaultSettings(setting);
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
     * @param selectBox
     * @private
     */
    proto._acceptClick = function (selectBox) {
        this.markBarAsHidden();

        let url = selectBox.options[selectBox.selectedIndex].value;

        if (url.length) {
            window.location = url;
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