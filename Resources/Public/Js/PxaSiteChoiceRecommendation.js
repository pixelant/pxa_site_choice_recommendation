PxaSiteChoiceRecommendation = function () {
    /**
     * @constructor
     */
    function PxaSiteChoiceRecommendation()
    {
        // Ajax loading bar url
        this.ajaxUrl = '/?type=8790341';
        // Default settings
        this._defaultSettings = {
            querySelector: 'body',
            insertMethod: 'insertBefore'
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
     * Default bar processing
     *
     * @param response
     * @private
     */
    proto._defaultProcessBarResponse = function (response) {
        if (response.visible) {
            let settings = response.settings || this.__getDefaultSettings();

            let querySelector = response.settings.querySelector || this.__getDefaultSettings('querySelector'),
                insertMethod = response.settings.insertMethod || this.__getDefaultSettings('insertMethod'),
                bar = this.__htmlToElement(response.html);

            let parentDom = document.querySelector(querySelector);

            if (insertMethod === 'insertBefore') {
                parentDom.insertBefore(bar, parentDom.firstChild);
            } else {
                parentDom[insertMethod](bar);
            }
        }
    };

    /**
     * Get default settings
     *
     * @param concreteSetting If specified - value of provided setting returned
     * @return {string|object}
     * @private
     */
    proto.__getDefaultSettings = function (concreteSetting) {
        if (typeof concreteSetting === 'string') {
            return this._defaultSettings[concreteSetting] || null;
        }

        return this._defaultSettings;
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